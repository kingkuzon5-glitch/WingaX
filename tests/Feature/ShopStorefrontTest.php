<?php

use App\Models\Product;
use App\Models\Store;

test('a shop storefront only lists that shop\'s published products', function () {
    $storeA = Store::factory()->create(['name' => 'Shop A']);
    $storeB = Store::factory()->create(['name' => 'Shop B']);

    $productA = Product::factory()->create(['store_id' => $storeA->id, 'status' => 'published', 'name' => 'A Item']);
    $draftA = Product::factory()->create(['store_id' => $storeA->id, 'status' => 'draft', 'name' => 'A Draft Item']);
    $productB = Product::factory()->create(['store_id' => $storeB->id, 'status' => 'published', 'name' => 'B Item']);

    $response = $this->get("/{$storeA->slug}");

    $response->assertSuccessful();
    $response->assertSee($storeA->name);
    $response->assertSee($productA->name);
    $response->assertDontSee($draftA->name);
    $response->assertDontSee($productB->name);
});

test('unknown shop slugs 404', function () {
    $this->get('/this-shop-does-not-exist')->assertNotFound();
});
