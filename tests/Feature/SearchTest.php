<?php

use App\Models\Category;
use App\Models\Product;

test('search matches product name', function () {
    $match = Product::factory()->create(['status' => 'published', 'name' => 'Wireless Bluetooth Speaker']);
    $noMatch = Product::factory()->create(['status' => 'published', 'name' => 'Leather Wallet']);

    $response = $this->get('/search?q=Bluetooth');

    $response->assertSuccessful();
    $response->assertSee($match->name);
    $response->assertDontSee($noMatch->name);
});

test('search matches product description', function () {
    $match = Product::factory()->create([
        'status' => 'published',
        'name' => 'Mystery Box',
        'description' => 'A premium noise-cancelling experience',
    ]);

    $response = $this->get('/search?q=noise-cancelling');

    $response->assertSuccessful();
    $response->assertSee($match->name);
});

test('search matches category name', function () {
    $category = Category::factory()->create(['name' => 'Smart Watches']);
    $match = Product::factory()->create(['status' => 'published', 'category_id' => $category->id]);

    $response = $this->get('/search?q=Smart Watches');

    $response->assertSuccessful();
    $response->assertSee($match->name);
});

test('search excludes draft products', function () {
    $draft = Product::factory()->create(['status' => 'draft', 'name' => 'Hidden Gadget']);

    $response = $this->get('/search?q=Hidden');

    $response->assertSuccessful();
    $response->assertDontSee($draft->name);
});
