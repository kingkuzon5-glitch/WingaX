<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WhatsappClick;
use App\Services\WhatsAppMessageBuilder;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class WhatsAppController extends Controller
{
    public function redirect(WhatsAppMessageBuilder $builder, Product $product): RedirectResponse
    {
        abort_unless($product->status === 'published', Response::HTTP_NOT_FOUND);

        WhatsappClick::create([
            'store_id' => $product->store_id,
            'product_id' => $product->id,
        ]);

        return redirect()->away($builder->urlFor($product));
    }
}
