@props(['product'])

@php
    $cover = $product->images->first();
    $video = $product->videos->first();
    $availabilityLabel = match ($product->availability) {
        'in_stock' => 'In Stock',
        'limited' => 'Limited Stock',
        'out_of_stock' => 'Out of Stock',
        default => $product->availability,
    };
@endphp

<section class="feed-item h-screen w-full snap-start snap-always relative bg-surface-variant" data-view-url="{{ route('products.view', $product) }}">
    @if ($video)
        <video class="absolute inset-0 w-full h-full object-cover" muted loop playsinline preload="none"
               poster="{{ $cover?->url }}" data-src="{{ $video->url }}"></video>
    @elseif ($cover)
        <img src="{{ $cover->url }}" alt="{{ $product->name }}" loading="lazy" decoding="async"
             class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 flex items-center justify-center text-outline-variant">
            <span class="material-symbols-outlined text-[64px]">image</span>
        </div>
    @endif

    <div class="absolute inset-0 bg-gradient-to-t from-background/90 via-background/40 to-transparent pointer-events-none"></div>

    <div class="absolute bottom-0 w-full pb-[calc(80px+env(safe-area-inset-bottom))] md:pb-xl px-edge-margin z-10">
        <div class="flex justify-between items-end mb-sm">
            <div class="flex-1 max-w-[80%]">
                <span class="inline-block px-xs py-1 mb-2 bg-surface/50 backdrop-blur-md border border-outline-variant/30 rounded-full font-label-bold text-label-bold text-on-surface uppercase">
                    {{ $product->category->name }}
                </span>
                <a href="{{ route('shop.show', $product->store) }}" class="flex items-center gap-1 mb-1 font-label-bold text-label-bold text-on-surface-variant drop-shadow-sm hover:text-primary transition-colors w-fit">
                    <span class="material-symbols-outlined text-[14px]">storefront</span>
                    {{ $product->store->name }}
                </a>
                <a href="{{ route('products.show', $product) }}" class="block">
                    <h2 class="font-title-md text-title-md text-on-background mb-1 drop-shadow-sm">{{ $product->name }}</h2>
                    <x-price :price="$product->price" :discount-price="$product->discount_price" size="lg" class="drop-shadow-sm mb-1" />
                    @if ($product->description)
                        <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 max-w-[28rem]">{{ $product->description }}</p>
                    @endif
                    <span class="inline-flex items-center gap-1 mt-2 font-label-bold text-label-bold {{ $product->availability === 'out_of_stock' ? 'text-error' : 'text-tertiary' }}">
                        <span class="material-symbols-outlined text-[14px] filled">{{ $product->availability === 'out_of_stock' ? 'cancel' : 'check_circle' }}</span>
                        {{ $availabilityLabel }}
                    </span>
                </a>
            </div>
            <div class="flex flex-col gap-md items-center pb-md">
                <x-share-button :url="route('products.show', $product)" :title="$product->name" />
            </div>
        </div>
        <x-whatsapp-button :product="$product" />
    </div>
</section>
