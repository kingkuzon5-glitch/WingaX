<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount(['products' => fn ($q) => $q->published()])
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $products = $category->products()
            ->published()
            ->with(['category', 'store', 'images' => fn ($q) => $q->orderBy('sort_order')->limit(1)])
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
