<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Notifications\DatabaseNotification;

beforeEach(function () {
    $this->seed(RoleSeeder::class);

    $this->user = User::factory()->create();
    $this->user->assignRole('pembeli');
});

// Helper to create a fake notification
function createNotification(User $user, bool $read = false): string
{
    $id = \Illuminate\Support\Str::uuid()->toString();

    \Illuminate\Support\Facades\DB::table('notifications')->insert([
        'id' => $id,
        'type' => 'App\\Notifications\\OrderStatusChanged',
        'notifiable_type' => User::class,
        'notifiable_id' => $user->id,
        'data' => json_encode(['message' => 'Test notification']),
        'read_at' => $read ? now() : null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return $id;
}

// ── NTF-01: View unread notifications ────────────────────
test('user can view unread notifications', function () {
    createNotification($this->user);
    createNotification($this->user);

    $response = $this->actingAs($this->user)->get('/notifications');

    $response->assertStatus(200);
    $response->assertViewIs('notifications.index');
    $response->assertViewHas('notifications');
});

// ── NTF-02: Mark single notification as read ─────────────
test('user can mark single notification as read', function () {
    $id = createNotification($this->user);

    $response = $this->actingAs($this->user)->patch("/notifications/{$id}/read");

    $response->assertRedirect();

    $this->assertDatabaseHas('notifications', [
        'id' => $id,
    ]);

    $notification = \Illuminate\Support\Facades\DB::table('notifications')->where('id', $id)->first();
    expect($notification->read_at)->not->toBeNull();
});

// ── NTF-03: Mark all as read ─────────────────────────────
test('user can mark all notifications as read', function () {
    createNotification($this->user);
    createNotification($this->user);
    createNotification($this->user);

    $response = $this->actingAs($this->user)->post('/notifications/read-all');

    $response->assertRedirect();

    $unread = $this->user->unreadNotifications()->count();
    expect($unread)->toBe(0);
});

// ── NTF-04: Mark non-existent notification ───────────────
test('marking non-existent notification returns 404', function () {
    $fakeId = \Illuminate\Support\Str::uuid()->toString();

    $response = $this->actingAs($this->user)->patch("/notifications/{$fakeId}/read");

    $response->assertStatus(404);
});

// ── NTF-05: Cannot mark another user's notification ──────
test('user cannot mark another user notification as read', function () {
    $otherUser = User::factory()->create();
    $id = createNotification($otherUser);

    $response = $this->actingAs($this->user)->patch("/notifications/{$id}/read");

    // Should fail because notification is scoped to user
    $response->assertStatus(404);
});

// ── NTF-06: Guest cannot access notifications ────────────
test('guest cannot access notifications', function () {
    $response = $this->get('/notifications');

    $response->assertRedirect('/login');
});

// ── NTF-07: AJAX notification fetch ──────────────────────
test('notifications return JSON when requested via AJAX', function () {
    createNotification($this->user);

    $response = $this->actingAs($this->user)
        ->getJson('/notifications');

    $response->assertStatus(200);
    $response->assertJsonStructure(['data']);
});
