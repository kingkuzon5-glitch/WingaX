<?php

use App\Models\Product;
use App\Models\Store;
use App\Models\WhatsappClick;

test('whatsapp redirect logs a click and redirects to the correct shop number', function () {
    $store = Store::factory()->create(['whatsapp_number' => '255712345678']);
    $product = Product::factory()->create([
        'status' => 'published',
        'store_id' => $store->id,
        'name' => 'Test Speaker',
        'reference' => 'WX-9999',
        'price' => 45000,
    ]);

    $response = $this->get("/whatsapp/{$product->slug}");

    $response->assertRedirect();
    $location = $response->headers->get('Location');

    expect($location)->toStartWith('https://wa.me/255712345678?text=');
    expect(urldecode($location))->toContain('Test Speaker')
        ->toContain('WX-9999')
        ->toContain('45,000');

    expect(WhatsappClick::where('product_id', $product->id)->where('store_id', $store->id)->count())->toBe(1);
});

test('whatsapp number is never exposed in public page source', function () {
    $store = Store::factory()->create(['whatsapp_number' => '255799999999']);
    $product = Product::factory()->create(['status' => 'published', 'store_id' => $store->id]);

    $response = $this->get("/products/{$product->slug}");

    $response->assertSuccessful();
    $response->assertDontSee('255799999999');
});

test('whatsapp redirect 404s for a draft product', function () {
    $product = Product::factory()->create(['status' => 'draft']);

    $this->get("/whatsapp/{$product->slug}")->assertNotFound();
});
