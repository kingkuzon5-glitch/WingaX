<?php

namespace App\Services;

use App\Models\Product;

class WhatsAppMessageBuilder
{
    public function messageFor(Product $product): string
    {
        $price = number_format((float) $product->displayPrice(), 0);

        return "Habari, nimeona {$product->name} kwenye WingaX.\n"
            ."Reference: {$product->reference}\n"
            ."Bei: TZS {$price}\n"
            .'Naomba maelezo zaidi.';
    }

    public function urlFor(Product $product): string
    {
        $number = $this->sanitizedNumber($product);
        $text = rawurlencode($this->messageFor($product));

        return "https://wa.me/{$number}?text={$text}";
    }

    protected function sanitizedNumber(Product $product): string
    {
        $number = $product->store->whatsapp_number ?? '';

        return preg_replace('/\D+/', '', $number);
    }
}
