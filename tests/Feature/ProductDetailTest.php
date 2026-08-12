<?php

use App\Models\Product;
use App\Models\ProductView;

test('viewing a product page records a view', function () {
    $product = Product::factory()->create(['status' => 'published']);

    $this->get("/products/{$product->slug}")->assertSuccessful();

    expect(ProductView::where('product_id', $product->id)->count())->toBe(1);
});

test('viewing the same product twice in one session only records one view', function () {
    $product = Product::factory()->create(['status' => 'published']);

    $first = $this->get("/products/{$product->slug}");
    $first->assertSuccessful();

    $sessionCookie = collect($first->headers->getCookies())
        ->first(fn ($cookie) => $cookie->getName() === config('session.cookie'));

    $this->withUnencryptedCookie($sessionCookie->getName(), $sessionCookie->getValue())
        ->get("/products/{$product->slug}")
        ->assertSuccessful();

    expect(ProductView::where('product_id', $product->id)->count())->toBe(1);
});

test('draft products are not publicly visible', function () {
    $product = Product::factory()->create(['status' => 'draft']);

    $this->get("/products/{$product->slug}")->assertNotFound();
});

test('product detail page shows shop attribution and more from shop', function () {
    $store = \App\Models\Store::factory()->create();
    $product = Product::factory()->create(['status' => 'published', 'store_id' => $store->id]);
    $otherFromSameShop = Product::factory()->create(['status' => 'published', 'store_id' => $store->id]);

    $response = $this->get("/products/{$product->slug}");

    $response->assertSuccessful();
    $response->assertSee($store->name);
    $response->assertSee($otherFromSameShop->name);
});
