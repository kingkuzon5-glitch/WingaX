<?php

use App\Models\Store;
use App\Models\User;

test('guests are redirected away from the admin dashboard', function () {
    $this->get('/admin')->assertRedirect('/login');
});

test('a seeded vendor can log in and reach the dashboard', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);
    Store::factory()->create(['user_id' => $user->id]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/admin');
    $this->assertAuthenticatedAs($user);
});

test('an authenticated vendor visiting login is redirected to the dashboard', function () {
    $user = User::factory()->create();
    Store::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/login');

    $response->assertRedirect('/admin');
});

test('logout ends the session', function () {
    $user = User::factory()->create();
    Store::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)->post('/admin/logout')->assertRedirect('/login');
    $this->assertGuest();
});
