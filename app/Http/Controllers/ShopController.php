<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function show(Store $store): View
    {
        $products = $store->products()
            ->published()
            ->with(['category', 'images' => fn ($q) => $q->orderBy('sort_order')->limit(1)])
            ->latest()
            ->paginate(9);

        $stats = [
            'products' => $store->products()->published()->count(),
            'categories' => $store->products()->published()->distinct('category_id')->count('category_id'),
            'memberSince' => $store->created_at,
        ];

        return view('shop.show', compact('store', 'products', 'stats'));
    }
}
