<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Product::class);

        $query = Product::query()
            ->where('store_id', Auth::user()->store->id)
            ->with(['category', 'images' => fn ($q) => $q->orderBy('sort_order')->limit(1)]);

        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->query('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $this->authorize('create', Product::class);

        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['images', 'video', 'spec_labels', 'spec_values']);
        $data['store_id'] = Auth::user()->store->id;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_deal'] = $request->boolean('is_deal');
        $data['specs'] = $this->zipSpecs($request->input('spec_labels', []), $request->input('spec_values', []));

        $product = Product::create($data);

        $this->storeImages($product, $request);
        $this->storeVideo($product, $request);

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        $product->load(['images', 'videos']);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->except(['images', 'video', 'spec_labels', 'spec_values']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_deal'] = $request->boolean('is_deal');
        $data['specs'] = $this->zipSpecs($request->input('spec_labels', []), $request->input('spec_values', []));

        $product->update($data);

        $this->storeImages($product, $request);
        $this->storeVideo($product, $request);

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        foreach ($product->videos as $video) {
            Storage::disk('public')->delete($video->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    public function destroyImage(Product $product, ProductImage $image): RedirectResponse
    {
        $this->authorize('update', $product);
        abort_unless($image->product_id === $product->id, 404);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('status', 'Image removed.');
    }

    public function destroyVideo(Product $product, ProductVideo $video): RedirectResponse
    {
        $this->authorize('update', $product);
        abort_unless($video->product_id === $product->id, 404);

        Storage::disk('public')->delete($video->path);
        $video->delete();

        return back()->with('status', 'Video removed.');
    }

    protected function storeImages(Product $product, Request $request): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $nextOrder = (int) $product->images()->max('sort_order') + 1;

        foreach ($request->file('images') as $i => $file) {
            $path = $file->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'sort_order' => $nextOrder + $i,
            ]);
        }
    }

    protected function storeVideo(Product $product, Request $request): void
    {
        if (! $request->hasFile('video')) {
            return;
        }

        foreach ($product->videos as $existing) {
            Storage::disk('public')->delete($existing->path);
            $existing->delete();
        }

        $path = $request->file('video')->store('products/videos', 'public');

        ProductVideo::create([
            'product_id' => $product->id,
            'path' => $path,
        ]);
    }

    protected function zipSpecs(array $labels, array $values): ?array
    {
        $specs = [];

        foreach ($labels as $i => $label) {
            $label = trim((string) $label);
            $value = trim((string) ($values[$i] ?? ''));

            if ($label !== '' && $value !== '') {
                $specs[$label] = $value;
            }
        }

        return $specs === [] ? null : $specs;
    }
}
