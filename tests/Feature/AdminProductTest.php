<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function vendorWithStore(): array
{
    $user = User::factory()->create();
    $store = Store::factory()->create(['user_id' => $user->id]);

    return [$user, $store];
}

test('a vendor can create a product with images', function () {
    Storage::fake('public');
    [$user, $store] = vendorWithStore();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post('/admin/products', [
        'category_id' => $category->id,
        'name' => 'New Gadget',
        'description' => 'A great gadget',
        'price' => 50000,
        'availability' => 'in_stock',
        'status' => 'published',
        'images' => [UploadedFile::fake()->image('gadget.jpg')],
    ]);

    $response->assertRedirect('/admin/products');

    $product = Product::where('name', 'New Gadget')->first();
    expect($product)->not->toBeNull();
    expect($product->store_id)->toBe($store->id);
    expect($product->images)->toHaveCount(1);
    expect($product->slug)->not->toBeEmpty();
    expect($product->reference)->toStartWith('WX-');
});

test('a vendor cannot edit another shop\'s product', function () {
    [, $ownerStore] = vendorWithStore();
    [$intruder] = vendorWithStore();
    $product = Product::factory()->create(['store_id' => $ownerStore->id]);

    $this->actingAs($intruder)->get("/admin/products/{$product->id}/edit")->assertForbidden();
    $this->actingAs($intruder)->put("/admin/products/{$product->id}", ['name' => 'Hacked'])->assertForbidden();
    $this->actingAs($intruder)->delete("/admin/products/{$product->id}")->assertForbidden();

    expect($product->fresh()->name)->not->toBe('Hacked');
});

test('a vendor only sees their own products in the admin index', function () {
    [$userA, $storeA] = vendorWithStore();
    [$userB, $storeB] = vendorWithStore();

    $productA = Product::factory()->create(['store_id' => $storeA->id, 'name' => 'Shop A Item']);
    $productB = Product::factory()->create(['store_id' => $storeB->id, 'name' => 'Shop B Item']);

    $response = $this->actingAs($userA)->get('/admin/products');

    $response->assertSuccessful();
    $response->assertSee($productA->name);
    $response->assertDontSee($productB->name);
});

test('creating a product requires a category and price', function () {
    [$user] = vendorWithStore();

    $response = $this->actingAs($user)->post('/admin/products', [
        'name' => 'Incomplete Product',
    ]);

    $response->assertSessionHasErrors(['category_id', 'price', 'availability', 'status', 'images']);
});

test('discount price must be lower than price', function () {
    [$user] = vendorWithStore();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post('/admin/products', [
        'category_id' => $category->id,
        'name' => 'Bad Discount',
        'price' => 1000,
        'discount_price' => 2000,
        'availability' => 'in_stock',
        'status' => 'published',
        'images' => [UploadedFile::fake()->image('x.jpg')],
    ]);

    $response->assertSessionHasErrors(['discount_price']);
});

test('a vendor can delete their own product and its images are removed from disk', function () {
    Storage::fake('public');
    [$user, $store] = vendorWithStore();
    $product = Product::factory()->create(['store_id' => $store->id]);
    $product->images()->create(['path' => 'products/test.jpg', 'sort_order' => 0]);
    Storage::disk('public')->put('products/test.jpg', 'fake-content');

    $this->actingAs($user)->delete("/admin/products/{$product->id}")->assertRedirect('/admin/products');

    expect(Product::find($product->id))->toBeNull();
    Storage::disk('public')->assertMissing('products/test.jpg');
});
