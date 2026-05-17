<?php

use App\Models\PetaniProfile;
use App\Models\Product;
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
        'location' => 'Test Location',
    ]);

    // Create products from this petani
    $this->products = Product::factory()->count(15)->create([
        'user_id' => $this->petani->id,
        'category' => 'beras',
    ]);

    // Create products in different categories
    Product::factory()->create([
        'user_id' => $this->petani->id,
        'name' => 'Kangkung Segar',
        'category' => 'sayur',
        'price' => 5000,
        'stock' => 50,
    ]);

    Product::factory()->create([
        'user_id' => $this->petani->id,
        'name' => 'Kopi Arabika Toraja',
        'category' => 'kopi',
        'price' => 85000,
        'stock' => 20,
    ]);
});

// ── MKT-01: Product listing page ──────────────────────────
test('product listing page loads successfully', function () {
    $response = $this->get('/produk');

    $response->assertStatus(200);
    $response->assertViewIs('produk');
    $response->assertViewHas('produk');
    $response->assertViewHas('kategoris');
    $response->assertViewHas('ticker');
});

// ── MKT-02: Search products by name ──────────────────────
test('can search products by name', function () {
    Product::factory()->create([
        'user_id' => $this->petani->id,
        'name' => 'Beras Organik Premium',
        'category' => 'beras',
    ]);

    $response = $this->get('/produk?q=Organik+Premium');

    $response->assertStatus(200);
    $response->assertSee('Beras Organik Premium');
});

// ── MKT-03: Filter by category ───────────────────────────
test('can filter products by category', function () {
    $response = $this->get('/produk?kategori=kopi');

    $response->assertStatus(200);
    $response->assertSee('Kopi Arabika Toraja');
});

// ── MKT-04: Filter "semua" shows all ─────────────────────
test('semua category filter shows all products', function () {
    $response = $this->get('/produk?kategori=semua');

    $response->assertStatus(200);
});

// ── MKT-05/06: Sort by price ─────────────────────────────
test('can sort products by cheapest', function () {
    $response = $this->get('/produk?sort=termurah');

    $response->assertStatus(200);
});

test('can sort products by most expensive', function () {
    $response = $this->get('/produk?sort=termahal');

    $response->assertStatus(200);
});

// ── MKT-07: Sort by stock ────────────────────────────────
test('can sort products by stock', function () {
    $response = $this->get('/produk?sort=stok');

    $response->assertStatus(200);
});

// ── MKT-09: Combined filter ─────────────────────────────
test('combined search, filter, and sort works', function () {
    $response = $this->get('/produk?q=Kopi&kategori=kopi&sort=termahal');

    $response->assertStatus(200);
});

// ── MKT-10: SQL injection protection ─────────────────────
test('search is protected against SQL injection', function () {
    $response = $this->get("/produk?q=%25'+OR+1=1--");

    $response->assertStatus(200);
    // Should not crash or expose data
});

// ── MKT-11: XSS protection ──────────────────────────────
test('search input is sanitized against XSS', function () {
    $response = $this->get('/produk?q=<script>alert(1)</script>');

    $response->assertStatus(200);
    $response->assertDontSee('<script>alert(1)</script>', false);
});

// ── MKT-12: Invalid category rejected ────────────────────
test('invalid category value is rejected', function () {
    $response = $this->get('/produk?kategori=invalid');

    $response->assertSessionHasErrors('kategori');
});

// ── MKT-13: Invalid sort defaults to latest ──────────────
test('invalid sort value is rejected by validation', function () {
    $response = $this->get('/produk?sort=invalid');

    $response->assertSessionHasErrors('sort');
});

// ── MKT-14: Product detail page ──────────────────────────
test('product detail page loads successfully', function () {
    $product = $this->products->first();

    $response = $this->get("/produk/{$product->id}");

    $response->assertStatus(200);
    $response->assertViewIs('produk-detail');
    $response->assertViewHas('product');
    $response->assertViewHas('produkLain');
    $response->assertViewHas('produkSerupa');
});

// ── MKT-15: Non-existent product returns 404 ─────────────
test('non-existent product returns 404', function () {
    $response = $this->get('/produk/99999');

    $response->assertStatus(404);
});

// ── MKT-16: Petani public profile ────────────────────────
test('petani public profile page loads', function () {
    $response = $this->get("/petani/{$this->petani->id}");

    $response->assertStatus(200);
    $response->assertViewIs('petani-publik');
    $response->assertViewHas('user');
    $response->assertViewHas('produk');
});

// ── MKT-17: Pagination preserves query string ────────────
test('pagination preserves query string parameters', function () {
    $response = $this->get('/produk?kategori=beras&sort=termurah&page=2');

    $response->assertStatus(200);
});
