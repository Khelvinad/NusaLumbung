<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register as petani and profile is created', function () {
    $response = $this->post('/register', [
        'name' => 'Test Petani',
        'email' => 'petani@example.com',
        'phone' => '081234567890',
        'role' => 'petani',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('email', 'petani@example.com')->first();
    
    expect($user->hasRole('petani'))->toBeTrue();

    $this->assertDatabaseHas('petani_profiles', [
        'user_id' => $user->id,
        'no_telp' => '081234567890',
        'farm_name' => 'Test Petani Farm',
    ]);
});

test('new users can register as pembeli and profile is created', function () {
    $response = $this->post('/register', [
        'name' => 'Test Pembeli',
        'email' => 'pembeli@example.com',
        'phone' => '089876543210',
        'role' => 'pembeli',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('email', 'pembeli@example.com')->first();
    
    expect($user->hasRole('pembeli'))->toBeTrue();

    $this->assertDatabaseHas('pembeli_profiles', [
        'user_id' => $user->id,
        'no_telp' => '089876543210',
    ]);
});