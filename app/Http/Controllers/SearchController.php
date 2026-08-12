<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $products = null;

        if ($q !== '') {
            $products = Product::query()
                ->published()
                ->with(['category', 'store', 'images' => fn ($query) => $query->orderBy('sort_order')->limit(1)])
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$q}%"));
                })
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        $popularCategories = Category::query()->orderBy('name')->limit(6)->get();

        return view('search.index', compact('products', 'q', 'popularCategories'));
    }
}
