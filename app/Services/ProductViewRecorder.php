<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Http\Request;

class ProductViewRecorder
{
    public function record(Product $product, Request $request): bool
    {
        $sessionId = $request->session()->getId();

        $alreadyViewed = ProductView::query()
            ->where('product_id', $product->id)
            ->where('session_id', $sessionId)
            ->exists();

        if ($alreadyViewed) {
            return false;
        }

        ProductView::create([
            'store_id' => $product->store_id,
            'product_id' => $product->id,
            'session_id' => $sessionId,
        ]);

        return true;
    }
}
