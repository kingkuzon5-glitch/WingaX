<?php

use App\Models\Store;
use App\Models\User;

test('a new vendor can register and gets their own shop', function () {
    $response = $this->post('/register', [
        'owner_name' => 'Grace Mwakyusa',
        'email' => 'grace@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'shop_name' => 'Grace Boutique',
        'whatsapp_number' => '255712000111',
        'location' => 'Mbeya',
    ]);

    $response->assertRedirect('/admin');

    $user = User::where('email', 'grace@example.com')->first();
    expect($user)->not->toBeNull();

    $store = Store::where('user_id', $user->id)->first();
    expect($store)->not->toBeNull();
    expect($store->name)->toBe('Grace Boutique');
    expect($store->slug)->toBe('grace-boutique');

    $this->assertAuthenticatedAs($user);
});

test('registration requires a unique email', function () {
    $existing = User::factory()->create(['email' => 'taken@example.com']);
    Store::factory()->create(['user_id' => $existing->id]);

    $response = $this->post('/register', [
        'owner_name' => 'Someone',
        'email' => 'taken@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'shop_name' => 'Another Shop',
        'whatsapp_number' => '255712000222',
    ]);

    $response->assertSessionHasErrors('email');
});

test('shop slugs never collide with reserved platform routes', function () {
    $store = Store::create([
        'user_id' => User::factory()->create()->id,
        'name' => 'Admin',
        'whatsapp_number' => '255712000333',
    ]);

    expect($store->slug)->not->toBe('admin');
});
