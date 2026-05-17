<?php

use App\Enums\OrderStatus;
use App\Exceptions\InsufficientStockException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PembeliProfile;
use App\Models\PetaniProfile;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);

    $this->petani = User::factory()->create();
    $this->petani->assignRole('petani');
    PetaniProfile::create([
        'user_id' => $this->petani->id,
        'no_telp' => '081234567890',
        'farm_name' => 'Test Farm',
        'location' => 'Test',
    ]);

    $this->pembeli = User::factory()->create();
    $this->pembeli->assignRole('pembeli');
    PembeliProfile::create([
        'user_id' => $this->pembeli->id,
        'no_telp' => '089876543210',
    ]);

    $this->product = Product::factory()->create([
        'user_id' => $this->petani->id,
        'name' => 'Beras Premium',
        'price' => 15000,
        'stock' => 100,
    ]);
});

// ── ORD-01: Checkout with valid items ────────────────────
test('pembeli can checkout with valid items', function () {
    $response = $this->actingAs($this->pembeli)->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => $this->product->id, 'quantity' => 3],
        ],
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('orders', [
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'status' => 'pending',
    ]);
});

// ── ORD-02: Checkout with insufficient stock ─────────────
test('checkout fails with insufficient stock', function () {
    $response = $this->actingAs($this->pembeli)->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => $this->product->id, 'quantity' => 999],
        ],
    ]);

    $response->assertStatus(422);
});

// ── ORD-03: Checkout with non-existent product ──────────
test('checkout fails with non-existent product', function () {
    $response = $this->actingAs($this->pembeli)->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => 99999, 'quantity' => 1],
        ],
    ]);

    $response->assertStatus(422);
});

// ── ORD-04: Checkout with empty items ────────────────────
test('checkout fails with empty items array', function () {
    $response = $this->actingAs($this->pembeli)->postJson('/pembeli/checkout', [
        'items' => [],
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('items');
});

// ── ORD-05: Checkout with quantity=0 ─────────────────────
test('checkout fails with zero quantity', function () {
    $response = $this->actingAs($this->pembeli)->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => $this->product->id, 'quantity' => 0],
        ],
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('items.0.quantity');
});

// ── ORD-06: Orders grouped by petani ─────────────────────
test('checkout groups orders by petani', function () {
    $petani2 = User::factory()->create();
    $petani2->assignRole('petani');
    $product2 = Product::factory()->create([
        'user_id' => $petani2->id,
        'stock' => 50,
    ]);

    $response = $this->actingAs($this->pembeli)->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => $this->product->id, 'quantity' => 1],
            ['product_id' => $product2->id, 'quantity' => 1],
        ],
    ]);

    $response->assertStatus(201);
    expect(Order::count())->toBe(2);
});

// ── ORD-07: Total amount calculation ─────────────────────
test('checkout calculates total amount correctly', function () {
    $this->actingAs($this->pembeli)->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => $this->product->id, 'quantity' => 3],
        ],
    ]);

    $order = Order::where('pembeli_id', $this->pembeli->id)->first();
    // price=15000 * qty=3 = 45000
    expect((float) $order->total_amount)->toBe(45000.00);
});

// ── ORD-08: Petani confirms pending order ────────────────
test('petani can confirm pending order', function () {
    $order = Order::factory()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'status' => OrderStatus::Pending,
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $this->product->id,
        'quantity' => 2,
        'price_snapshot' => 15000,
        'product_name_snapshot' => 'Beras Premium',
    ]);

    $response = $this->actingAs($this->petani)->patch("/petani/orders/{$order->id}/confirm");

    $response->assertRedirect();
    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Confirmed);

    // Stock should be decremented
    $this->product->refresh();
    expect($this->product->stock)->toBe(98);
});

// ── ORD-09: Confirm with insufficient stock ──────────────
test('confirm fails when stock is insufficient', function () {
    $this->product->update(['stock' => 1]);

    $order = Order::factory()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'status' => OrderStatus::Pending,
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $this->product->id,
        'quantity' => 10,
        'price_snapshot' => 15000,
        'product_name_snapshot' => 'Beras Premium',
    ]);

    $response = $this->actingAs($this->petani)->patch("/petani/orders/{$order->id}/confirm");

    $response->assertStatus(422);
});

// ── ORD-11: Petani confirms another's order → 403 ───────
test('petani cannot confirm another petani order', function () {
    $otherPetani = User::factory()->create();
    $otherPetani->assignRole('petani');

    $order = Order::factory()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $otherPetani->id,
        'status' => OrderStatus::Pending,
    ]);

    $response = $this->actingAs($this->petani)->patch("/petani/orders/{$order->id}/confirm");

    $response->assertStatus(403);
});

// ── ORD-12: Petani ships confirmed order ─────────────────
test('petani can ship confirmed order', function () {
    $order = Order::factory()->confirmed()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
    ]);

    $response = $this->actingAs($this->petani)->patch("/petani/orders/{$order->id}/update-status", [
        'status' => 'shipped',
    ]);

    $response->assertRedirect();
    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Shipped);
});

// ── ORD-13: Pembeli marks shipped as done ────────────────
test('pembeli can mark shipped order as done', function () {
    $order = Order::factory()->shipped()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
    ]);

    $response = $this->actingAs($this->pembeli)->patch("/pembeli/orders/{$order->id}/update-status", [
        'status' => 'done',
    ]);

    $response->assertRedirect();
    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Done);
});

// ── ORD-14: Pembeli cancels pending order ────────────────
test('pembeli can cancel pending order', function () {
    $order = Order::factory()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'status' => OrderStatus::Pending,
    ]);

    $response = $this->actingAs($this->pembeli)->patch("/pembeli/orders/{$order->id}/update-status", [
        'status' => 'cancelled',
    ]);

    $response->assertRedirect();
    $order->refresh();
    expect($order->status)->toBe(OrderStatus::Cancelled);
});

// ── ORD-15: Cancel confirmed restores stock ──────────────
test('cancelling confirmed order restores stock', function () {
    $order = Order::factory()->confirmed()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $this->product->id,
        'quantity' => 5,
        'price_snapshot' => 15000,
        'product_name_snapshot' => 'Beras',
    ]);

    $stockBefore = $this->product->fresh()->stock;

    $this->actingAs($this->petani)->patch("/petani/orders/{$order->id}/update-status", [
        'status' => 'cancelled',
    ]);

    $this->product->refresh();
    expect($this->product->stock)->toBe($stockBefore + 5);
});

// ── ORD-17: Invalid transition pending→shipped ──────────
test('cannot transition directly from pending to shipped', function () {
    $order = Order::factory()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'status' => OrderStatus::Pending,
    ]);

    $response = $this->actingAs($this->petani)->patch("/petani/orders/{$order->id}/update-status", [
        'status' => 'shipped',
    ]);

    $response->assertStatus(403);
});

// ── ORD-18: Done order cannot be cancelled ───────────────
test('done order cannot be cancelled', function () {
    $order = Order::factory()->done()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
    ]);

    $response = $this->actingAs($this->pembeli)->patch("/pembeli/orders/{$order->id}/update-status", [
        'status' => 'cancelled',
    ]);

    // Policy rejects: done→cancelled is not allowed
    $response->assertStatus(403);
});

// ── ORD-19: Pembeli views own orders ─────────────────────
test('pembeli can view own orders', function () {
    Order::factory()->count(3)->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
    ]);

    $response = $this->actingAs($this->pembeli)->get('/pembeli/orders');

    $response->assertStatus(200);
});

// ── ORD-20: Pembeli views single order ───────────────────
test('pembeli can view own order detail', function () {
    $order = Order::factory()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $this->product->id,
        'quantity' => 1,
        'price_snapshot' => $this->product->price,
        'product_name_snapshot' => $this->product->name,
    ]);

    // Use JSON request since the Blade view (pembeli.orders.show) doesn't exist yet
    $response = $this->actingAs($this->pembeli)->getJson("/pembeli/orders/{$order->id}");

    $response->assertStatus(200);
    $response->assertJsonPath('data.id', $order->id);
});

// ── ORD-21: Pembeli cannot view another's order ──────────
test('pembeli cannot view another pembeli order', function () {
    $otherPembeli = User::factory()->create();
    $otherPembeli->assignRole('pembeli');

    $order = Order::factory()->create([
        'pembeli_id' => $otherPembeli->id,
        'petani_id' => $this->petani->id,
    ]);

    $response = $this->actingAs($this->pembeli)->get("/pembeli/orders/{$order->id}");

    $response->assertStatus(403);
});

// ── ORD-23: Guest cannot checkout ────────────────────────
test('guest cannot checkout', function () {
    $response = $this->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => $this->product->id, 'quantity' => 1],
        ],
    ]);

    // Should be redirected or get 401
    $response->assertUnauthorized();
});

// ── ORD-24: Petani cannot checkout ───────────────────────
test('petani cannot checkout', function () {
    $response = $this->actingAs($this->petani)->postJson('/pembeli/checkout', [
        'items' => [
            ['product_id' => $this->product->id, 'quantity' => 1],
        ],
    ]);

    $response->assertStatus(403);
});
