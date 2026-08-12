@props(['product'])

@php
    $cover = $product->images->first();
@endphp

<div class="group bg-surface-container-lowest rounded-DEFAULT shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col active:scale-[0.98] transition-transform">
    <a href="{{ route('products.show', $product) }}" class="relative w-full aspect-[4/5] bg-surface-variant overflow-hidden block">
        @if ($cover)
            <img src="{{ $cover->url }}" alt="{{ $product->name }}" loading="lazy" decoding="async"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-outline-variant">
                <span class="material-symbols-outlined text-[40px]">image</span>
            </div>
        @endif

        @if ($product->hasDiscount())
            <div class="absolute top-xs left-xs bg-primary text-on-primary font-label-bold text-label-bold px-2 py-1 rounded-full shadow-sm">
                -{{ $product->discountPercent() }}%
            </div>
        @elseif ($product->is_featured)
            <div class="absolute top-xs left-xs bg-on-background/80 backdrop-blur-md text-on-primary font-label-bold text-label-bold px-2 py-1 rounded-full shadow-sm">
                Featured
            </div>
        @endif
    </a>
    <div class="p-sm flex flex-col flex-grow">
        <span class="font-label-bold text-label-bold text-secondary mb-1">{{ $product->category->name }}</span>
        <a href="{{ route('products.show', $product) }}">
            <h3 class="font-body-sm text-body-sm text-on-surface font-semibold line-clamp-2 mb-2">{{ $product->name }}</h3>
        </a>
        <x-price :price="$product->price" :discount-price="$product->discount_price" size="sm" class="mb-2" />
        <a href="{{ route('shop.show', $product->store) }}" class="mt-auto flex items-center gap-1 font-label-bold text-label-bold text-on-surface-variant hover:text-primary transition-colors w-fit">
            <span class="material-symbols-outlined text-[12px]">storefront</span>
            <span class="truncate">{{ $product->store->name }}</span>
        </a>
    </div>
</div>
