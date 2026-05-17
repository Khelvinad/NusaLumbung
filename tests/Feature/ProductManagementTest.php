<?php

use App\Models\PetaniProfile;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    Storage::fake('public');

    $this->petani = User::factory()->create();
    $this->petani->assignRole('petani');
    PetaniProfile::create([
        'user_id' => $this->petani->id,
        'no_telp' => '081234567890',
        'farm_name' => 'Test Farm',
        'location' => 'Test Location',
    ]);

    $this->pembeli = User::factory()->create();
    $this->pembeli->assignRole('pembeli');
});

// ── PRD-01: View own product list ────────────────────────
test('petani can view own product list', function () {
    Product::factory()->count(3)->create(['user_id' => $this->petani->id]);

    $response = $this->actingAs($this->petani)->get('/petani/produk');

    $response->assertStatus(200);
    $response->assertViewIs('petani.produk.index');
});

// ── PRD-02: Create product with valid data ───────────────
test('petani can create a product with valid data', function () {
    $photo = UploadedFile::fake()->create('product.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($this->petani)->post('/petani/produk', [
        'name' => 'Beras Merah Organik',
        'description' => 'Beras merah berkualitas',
        'price' => 25000,
        'stock' => 100,
        'category' => 'beras',
        'photo' => $photo,
    ]);

    $response->assertRedirect(route('petani.produk.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('products', [
        'user_id' => $this->petani->id,
        'name' => 'Beras Merah Organik',
        'price' => 25000,
        'stock' => 100,
        'category' => 'beras',
    ]);
});

// ── PRD-03: Create product missing name ──────────────────
test('product creation fails without name', function () {
    $response = $this->actingAs($this->petani)->post('/petani/produk', [
        'price' => 25000,
        'stock' => 100,
        'category' => 'beras',
    ]);

    $response->assertSessionHasErrors('name');
});

// ── PRD-04: Create product with price = 0 ────────────────
test('product can be created with price zero', function () {
    $response = $this->actingAs($this->petani)->post('/petani/produk', [
        'name' => 'Free Sample',
        'price' => 0,
        'stock' => 10,
        'category' => 'beras',
    ]);

    // Price 0 is allowed (min:0)
    $response->assertSessionDoesntHaveErrors('price');
});

// ── PRD-05: Negative price rejected ─────────────────────
test('product creation fails with negative price', function () {
    $response = $this->actingAs($this->petani)->post('/petani/produk', [
        'name' => 'Bad Product',
        'price' => -100,
        'stock' => 10,
        'category' => 'beras',
    ]);

    $response->assertSessionHasErrors('price');
});

// ── PRD-06: Invalid category rejected ────────────────────
test('product creation fails with invalid category', function () {
    $response = $this->actingAs($this->petani)->post('/petani/produk', [
        'name' => 'Electronics',
        'price' => 100,
        'stock' => 10,
        'category' => 'electronics',
    ]);

    $response->assertSessionHasErrors('category');
});

// ── PRD-07: Oversized photo rejected ─────────────────────
test('product creation fails with oversized photo', function () {
    $photo = UploadedFile::fake()->create('big.jpg', 3000, 'image/jpeg'); // 3MB > 2048KB

    $response = $this->actingAs($this->petani)->post('/petani/produk', [
        'name' => 'Product',
        'price' => 100,
        'stock' => 10,
        'category' => 'beras',
        'photo' => $photo,
    ]);

    $response->assertSessionHasErrors('photo');
});

// ── PRD-09: XSS sanitized in name ────────────────────────
test('XSS is sanitized in product name', function () {
    $this->actingAs($this->petani)->post('/petani/produk', [
        'name' => '<script>alert("xss")</script>Beras',
        'description' => '<img onerror=alert(1)>Deskripsi',
        'price' => 15000,
        'stock' => 50,
        'category' => 'beras',
    ]);

    $product = Product::where('user_id', $this->petani->id)->latest()->first();

    if ($product) {
        expect($product->name)->not->toContain('<script>');
        expect($product->description)->not->toContain('<img');
    }
});

// ── PRD-10: Edit own product ─────────────────────────────
test('petani can edit own product', function () {
    $product = Product::factory()->create(['user_id' => $this->petani->id]);

    $response = $this->actingAs($this->petani)->get("/petani/produk/{$product->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('petani.produk.form');
});

test('petani can update own product', function () {
    $product = Product::factory()->create(['user_id' => $this->petani->id]);

    $response = $this->actingAs($this->petani)->put("/petani/produk/{$product->id}", [
        'name' => 'Updated Product Name',
        'price' => 50000,
        'stock' => 200,
        'category' => 'kopi',
    ]);

    $response->assertRedirect(route('petani.produk.index'));

    $product->refresh();
    expect($product->name)->toBe('Updated Product Name');
    expect((float) $product->price)->toBe(50000.00);
});

// ── PRD-11: Edit another petani's product → 403 ─────────
test('petani cannot edit another petani product', function () {
    $otherPetani = User::factory()->create();
    $otherPetani->assignRole('petani');
    $product = Product::factory()->create(['user_id' => $otherPetani->id]);

    $response = $this->actingAs($this->petani)->get("/petani/produk/{$product->id}/edit");

    $response->assertStatus(403);
});

// ── PRD-12: Delete own product ───────────────────────────
test('petani can delete own product', function () {
    $product = Product::factory()->create(['user_id' => $this->petani->id]);

    $response = $this->actingAs($this->petani)->delete("/petani/produk/{$product->id}");

    $response->assertRedirect(route('petani.produk.index'));
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

// ── PRD-13: Delete another's product → 403 ──────────────
test('petani cannot delete another petani product', function () {
    $otherPetani = User::factory()->create();
    $otherPetani->assignRole('petani');
    $product = Product::factory()->create(['user_id' => $otherPetani->id]);

    $response = $this->actingAs($this->petani)->delete("/petani/produk/{$product->id}");

    $response->assertStatus(403);
});

// ── PRD-14: Pembeli cannot access petani routes ──────────
test('pembeli cannot access petani product creation', function () {
    $response = $this->actingAs($this->pembeli)->get('/petani/produk/create');

    $response->assertStatus(403);
});

test('pembeli cannot post to petani product store', function () {
    $response = $this->actingAs($this->pembeli)->post('/petani/produk', [
        'name' => 'Hack',
        'price' => 100,
        'stock' => 10,
        'category' => 'beras',
    ]);

    $response->assertStatus(403);
});

// ── PRD-15: Photo replacement ────────────────────────────
test('updating product photo deletes old photo', function () {
    $oldPhoto = UploadedFile::fake()->create('old.jpg', 100, 'image/jpeg');
    $product = Product::factory()->create([
        'user_id' => $this->petani->id,
        'photo_path' => $oldPhoto->store('products', 'public'),
    ]);

    $newPhoto = UploadedFile::fake()->create('new.jpg', 100, 'image/jpeg');

    $this->actingAs($this->petani)->put("/petani/produk/{$product->id}", [
        'name' => $product->name,
        'price' => $product->price,
        'stock' => $product->stock,
        'category' => $product->category,
        'photo' => $newPhoto,
    ]);

    $product->refresh();
    Storage::disk('public')->assertMissing($oldPhoto->hashName('products'));
    expect($product->photo_path)->not->toBeNull();
});

// ── PRD-14 extended: Guest cannot access ─────────────────
test('guest cannot access petani product routes', function () {
    $response = $this->get('/petani/produk');

    $response->assertRedirect('/login');
});

// ── Dashboard ────────────────────────────────────────────
test('petani dashboard loads with correct stats', function () {
    Product::factory()->count(5)->create(['user_id' => $this->petani->id]);

    $response = $this->actingAs($this->petani)->get('/petani/dashboard');

    $response->assertStatus(200);
    $response->assertViewIs('petani.dashboard');
    $response->assertViewHas('totalProduk', 5);
});
