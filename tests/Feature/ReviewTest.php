<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PembeliProfile;
use App\Models\PetaniProfile;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
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
        'rating_avg' => 0,
    ]);

    $this->pembeli = User::factory()->create();
    $this->pembeli->assignRole('pembeli');
    PembeliProfile::create([
        'user_id' => $this->pembeli->id,
        'no_telp' => '089876543210',
    ]);

    $this->product = Product::factory()->create(['user_id' => $this->petani->id]);

    $this->doneOrder = Order::factory()->done()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
    ]);
    OrderItem::create([
        'order_id' => $this->doneOrder->id,
        'product_id' => $this->product->id,
        'quantity' => 1,
        'price_snapshot' => $this->product->price,
        'product_name_snapshot' => $this->product->name,
    ]);
});

// ── REV-01: Submit review for done order ─────────────────
test('pembeli can submit review for done order', function () {
    $response = $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        [
            'rating' => 5,
            'comment' => 'Produk sangat bagus!',
        ]
    );

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('reviews', [
        'order_id' => $this->doneOrder->id,
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'rating' => 5,
        'comment' => 'Produk sangat bagus!',
    ]);
});

// ── REV-02: Cannot review non-done order ─────────────────
test('cannot submit review for non-done order', function () {
    $pendingOrder = Order::factory()->create([
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'status' => OrderStatus::Pending,
    ]);

    $response = $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$pendingOrder->id}/reviews",
        ['rating' => 5]
    );

    $response->assertStatus(403);
});

// ── REV-03: Cannot submit duplicate review ───────────────
test('cannot submit duplicate review for same order', function () {
    Review::create([
        'order_id' => $this->doneOrder->id,
        'pembeli_id' => $this->pembeli->id,
        'petani_id' => $this->petani->id,
        'product_id' => $this->product->id,
        'rating' => 4,
    ]);

    $response = $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        ['rating' => 5]
    );

    $response->assertStatus(403);
});

// ── REV-04: Cannot review another's order ────────────────
test('pembeli cannot review another pembeli order', function () {
    $otherPembeli = User::factory()->create();
    $otherPembeli->assignRole('pembeli');

    $otherOrder = Order::factory()->done()->create([
        'pembeli_id' => $otherPembeli->id,
        'petani_id' => $this->petani->id,
    ]);

    $response = $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$otherOrder->id}/reviews",
        ['rating' => 5]
    );

    $response->assertStatus(403);
});

// ── REV-05: Rating below minimum ─────────────────────────
test('rating below 1 is rejected', function () {
    $response = $this->actingAs($this->pembeli)->postJson(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        ['rating' => 0]
    );

    $response->assertJsonValidationErrors('rating');
});

// ── REV-06: Rating above maximum ─────────────────────────
test('rating above 5 is rejected', function () {
    $response = $this->actingAs($this->pembeli)->postJson(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        ['rating' => 6]
    );

    $response->assertJsonValidationErrors('rating');
});

// ── REV-07/08: Rating boundary values ────────────────────
test('rating of 1 is accepted', function () {
    $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        ['rating' => 1]
    );

    $this->assertDatabaseHas('reviews', [
        'order_id' => $this->doneOrder->id,
        'rating' => 1,
    ]);
});

test('rating of 5 is accepted', function () {
    $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        ['rating' => 5]
    );

    $this->assertDatabaseHas('reviews', [
        'order_id' => $this->doneOrder->id,
        'rating' => 5,
    ]);
});

// ── REV-10: Review without comment ───────────────────────
test('review can be submitted without comment', function () {
    $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        ['rating' => 4]
    );

    $this->assertDatabaseHas('reviews', [
        'order_id' => $this->doneOrder->id,
        'rating' => 4,
        'comment' => null,
    ]);
});

// ── REV-11: Rating average recalculation ─────────────────
test('petani rating avg is recalculated after review', function () {
    // Submit first review: rating = 4
    $this->actingAs($this->pembeli)->post(
        "/pembeli/orders/{$this->doneOrder->id}/reviews",
        ['rating' => 4]
    );

    // Create a second order and review with rating = 2
    $pembeli2 = User::factory()->create();
    $pembeli2->assignRole('pembeli');

    $order2 = Order::factory()->done()->create([
        'pembeli_id' => $pembeli2->id,
        'petani_id' => $this->petani->id,
    ]);
    OrderItem::create([
        'order_id' => $order2->id,
        'product_id' => $this->product->id,
        'quantity' => 1,
        'price_snapshot' => $this->product->price,
        'product_name_snapshot' => $this->product->name,
    ]);

    $this->actingAs($pembeli2)->post(
        "/pembeli/orders/{$order2->id}/reviews",
        ['rating' => 2]
    );

    $this->petani->petaniProfile->refresh();
    // Average of 4 and 2 = 3.00
    expect((float) $this->petani->petaniProfile->rating_avg)->toBe(3.00);
});
