<?php

use App\Models\Product;

test('home feed only shows published products', function () {
    $published = Product::factory()->create(['status' => 'published']);
    $draft = Product::factory()->create(['status' => 'draft']);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee($published->name);
    $response->assertDontSee($draft->name);
});

test('home feed mixes products from multiple shops', function () {
    $productA = Product::factory()->create(['status' => 'published']);
    $productB = Product::factory()->create(['status' => 'published']);

    expect($productA->store_id)->not->toBe($productB->store_id);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee($productA->name);
    $response->assertSee($productB->name);
});

test('feed infinite scroll endpoint returns more items', function () {
    Product::factory()->count(10)->create(['status' => 'published']);

    $response = $this->get('/feed/more');

    $response->assertSuccessful();
});
