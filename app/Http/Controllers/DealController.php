<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->published()
            ->deals()
            ->with(['category', 'store', 'images' => fn ($q) => $q->orderBy('sort_order')->limit(1)]);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->query('category')));
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::query()
            ->whereHas('products', fn ($q) => $q->published()->deals())
            ->orderBy('name')
            ->get();

        return view('deals.index', compact('products', 'categories'));
    }
}
