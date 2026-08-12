<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductFeedController extends Controller
{
    public function index(Request $request): View
    {
        $products = $this->feedQuery()->cursorPaginate(6);

        $desktopHighlights = Product::query()
            ->published()
            ->with(['category', 'store', 'images' => fn ($q) => $q->orderBy('sort_order')->limit(1)])
            ->latest()
            ->limit(5)
            ->get();

        return view('home', [
            'products' => $products,
            'desktopHighlights' => $desktopHighlights,
        ]);
    }

    public function more(Request $request): View
    {
        $products = $this->feedQuery()->cursorPaginate(6);

        return view('partials._feed-items', compact('products'));
    }

    protected function feedQuery()
    {
        return Product::query()
            ->published()
            ->with([
                'category',
                'store',
                'images' => fn ($q) => $q->orderBy('sort_order'),
                'videos' => fn ($q) => $q->latest()->limit(1),
            ])
            ->withCount('whatsappClicks')
            ->latest();
    }
}
