<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductViewRecorder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function show(Product $product, Request $request, ProductViewRecorder $recorder): View
    {
        abort_unless($product->status === 'published', Response::HTTP_NOT_FOUND);

        $product->load(['category', 'images', 'videos', 'store']);

        $recorder->record($product, $request);

        $moreFromShop = Product::query()
            ->published()
            ->where('store_id', $product->store_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => fn ($q) => $q->orderBy('sort_order')->limit(1)])
            ->latest()
            ->limit(6)
            ->get();

        $related = Product::query()
            ->published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => fn ($q) => $q->orderBy('sort_order')->limit(1)])
            ->latest()
            ->limit(6)
            ->get();

        return view('products.show', compact('product', 'related', 'moreFromShop'));
    }

    public function recordView(Product $product, Request $request, ProductViewRecorder $recorder): JsonResponse
    {
        abort_unless($product->status === 'published', Response::HTTP_NOT_FOUND);

        $recorded = $recorder->record($product, $request);

        return response()->json(['recorded' => $recorded]);
    }
}
