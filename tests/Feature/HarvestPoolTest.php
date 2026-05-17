<?php

use App\Enums\HarvestPoolStatus;
use App\Models\HarvestPool;
use App\Models\HarvestPoolMember;
use App\Models\PetaniProfile;
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
    ]);

    $this->pembeli = User::factory()->create();
    $this->pembeli->assignRole('pembeli');
});

// ── HP-01: View active pools ─────────────────────────────
test('petani can view active harvest pools', function () {
    HarvestPool::factory()->count(3)->create(['created_by' => $this->petani->id]);
    // Expired pool should not appear
    HarvestPool::factory()->expired()->create(['created_by' => $this->petani->id]);

    $response = $this->actingAs($this->petani)->get('/petani/harvest-pools');

    $response->assertStatus(200);
    $response->assertViewIs('petani.harvest-pools.index');
});

// ── HP-02: Create harvest pool ───────────────────────────
test('petani can create a harvest pool', function () {
    $response = $this->actingAs($this->petani)->post('/petani/harvest-pools', [
        'name' => 'Pool Beras Musim Panas',
        'commodity' => 'Beras',
        'unit' => 'kg',
        'target_qty' => 500,
        'deadline' => now()->addDays(14)->toDateString(),
    ]);

    $response->assertRedirect(route('petani.harvest-pools.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('harvest_pools', [
        'name' => 'Pool Beras Musim Panas',
        'commodity' => 'Beras',
        'unit' => 'kg',
        'created_by' => $this->petani->id,
        'status' => 'open',
    ]);
});

// ── HP-03: Past deadline rejected ────────────────────────
test('pool creation fails with past deadline', function () {
    $response = $this->actingAs($this->petani)->post('/petani/harvest-pools', [
        'name' => 'Pool',
        'commodity' => 'Beras',
        'unit' => 'kg',
        'target_qty' => 100,
        'deadline' => now()->subDay()->toDateString(),
    ]);

    $response->assertSessionHasErrors('deadline');
});

// ── HP-04: target_qty = 0 rejected ───────────────────────
test('pool creation fails with zero target quantity', function () {
    $response = $this->actingAs($this->petani)->post('/petani/harvest-pools', [
        'name' => 'Pool',
        'commodity' => 'Beras',
        'unit' => 'kg',
        'target_qty' => 0,
        'deadline' => now()->addDays(7)->toDateString(),
    ]);

    $response->assertSessionHasErrors('target_qty');
});

// ── HP-05: XSS sanitized ────────────────────────────────
test('XSS is sanitized in pool name and commodity', function () {
    $this->actingAs($this->petani)->post('/petani/harvest-pools', [
        'name' => '<script>alert(1)</script>Pool',
        'commodity' => '<img onerror=alert(1)>Beras',
        'unit' => 'kg',
        'target_qty' => 100,
        'deadline' => now()->addDays(7)->toDateString(),
    ]);

    $pool = HarvestPool::where('created_by', $this->petani->id)->first();
    if ($pool) {
        expect($pool->name)->not->toContain('<script>');
        expect($pool->commodity)->not->toContain('<img');
    }
});

// ── HP-06: Join open pool ────────────────────────────────
test('petani can join an open pool', function () {
    $pool = HarvestPool::factory()->create(['created_by' => $this->petani->id]);

    $petani2 = User::factory()->create();
    $petani2->assignRole('petani');

    $response = $this->actingAs($petani2)->post("/petani/harvest-pools/{$pool->id}/join", [
        'qty' => 25,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $pool->refresh();
    expect((float) $pool->current_qty)->toBe(25.00);

    $this->assertDatabaseHas('harvest_pool_members', [
        'harvest_pool_id' => $pool->id,
        'user_id' => $petani2->id,
    ]);
});

// ── HP-07: Auto-fulfill when target reached ──────────────
test('pool auto-fulfills when target quantity is reached', function () {
    $pool = HarvestPool::factory()->create([
        'created_by' => $this->petani->id,
        'target_qty' => 100,
        'current_qty' => 90,
    ]);

    $petani2 = User::factory()->create();
    $petani2->assignRole('petani');

    $this->actingAs($petani2)->post("/petani/harvest-pools/{$pool->id}/join", [
        'qty' => 10,
    ]);

    $pool->refresh();
    expect($pool->status)->toBe(HarvestPoolStatus::Fulfilled);
    expect((float) $pool->current_qty)->toBe(100.00);
});

// ── HP-08: Over-fulfill ──────────────────────────────────
test('pool can be over-fulfilled', function () {
    $pool = HarvestPool::factory()->create([
        'created_by' => $this->petani->id,
        'target_qty' => 100,
        'current_qty' => 95,
    ]);

    $petani2 = User::factory()->create();
    $petani2->assignRole('petani');

    $this->actingAs($petani2)->post("/petani/harvest-pools/{$pool->id}/join", [
        'qty' => 10,
    ]);

    $pool->refresh();
    expect($pool->status)->toBe(HarvestPoolStatus::Fulfilled);
    expect((float) $pool->current_qty)->toBe(105.00);
});

// ── HP-09: Cannot join twice ─────────────────────────────
test('petani cannot join same pool twice', function () {
    $pool = HarvestPool::factory()->create(['created_by' => $this->petani->id]);

    $petani2 = User::factory()->create();
    $petani2->assignRole('petani');

    // First join
    $this->actingAs($petani2)->post("/petani/harvest-pools/{$pool->id}/join", [
        'qty' => 10,
    ]);

    // Second join
    $response = $this->actingAs($petani2)->post("/petani/harvest-pools/{$pool->id}/join", [
        'qty' => 5,
    ]);

    $response->assertStatus(409);
});

// ── HP-10: Cannot join fulfilled pool ────────────────────
test('cannot join fulfilled pool', function () {
    $pool = HarvestPool::factory()->fulfilled()->create([
        'created_by' => $this->petani->id,
    ]);

    $petani2 = User::factory()->create();
    $petani2->assignRole('petani');

    $response = $this->actingAs($petani2)->post("/petani/harvest-pools/{$pool->id}/join", [
        'qty' => 10,
    ]);

    $response->assertStatus(403);
});

// ── HP-11: Cannot join expired pool ──────────────────────
test('cannot join expired pool', function () {
    $pool = HarvestPool::factory()->expired()->create([
        'created_by' => $this->petani->id,
    ]);

    $petani2 = User::factory()->create();
    $petani2->assignRole('petani');

    $response = $this->actingAs($petani2)->post("/petani/harvest-pools/{$pool->id}/join", [
        'qty' => 10,
    ]);

    $response->assertStatus(403);
});

// ── HP-12: Pembeli cannot create pool ────────────────────
test('pembeli cannot create harvest pool', function () {
    $response = $this->actingAs($this->pembeli)->post('/petani/harvest-pools', [
        'name' => 'Hack Pool',
        'commodity' => 'Beras',
        'unit' => 'kg',
        'target_qty' => 100,
        'deadline' => now()->addDays(7)->toDateString(),
    ]);

    $response->assertStatus(403);
});

// ── HP-13: View pool detail ──────────────────────────────
test('petani can view pool detail', function () {
    $pool = HarvestPool::factory()->create(['created_by' => $this->petani->id]);

    $response = $this->actingAs($this->petani)->get("/petani/harvest-pools/{$pool->id}");

    $response->assertStatus(200);
    $response->assertViewIs('petani.harvest-pools.show');
});

// ── Guest access ─────────────────────────────────────────
test('guest cannot access harvest pool routes', function () {
    $response = $this->get('/petani/harvest-pools');

    $response->assertRedirect('/login');
});
