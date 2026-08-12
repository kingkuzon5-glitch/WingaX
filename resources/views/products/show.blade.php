@php
    $cover = $product->images->first();
    $availabilityLabel = match ($product->availability) {
        'in_stock' => 'In Stock',
        'limited' => 'Limited Stock',
        'out_of_stock' => 'Out of Stock',
        default => $product->availability,
    };
@endphp

<x-layouts.app :title="$product->name" :description="Str::limit(strip_tags($product->description ?? $product->name), 150)"
    :og-image="$cover?->url" :back-url="url()->previous() !== url()->current() ? url()->previous() : route('home')">
    <div class="w-full max-w-4xl mx-auto pb-32 md:pb-xl relative">
        {{-- Image / video gallery --}}
        <section class="relative w-full aspect-[4/5] md:aspect-video bg-surface-variant overflow-hidden md:rounded-b-[2rem]">
            @if ($product->videos->isNotEmpty())
                <video class="w-full h-full object-cover" controls playsinline poster="{{ $cover?->url }}">
                    <source src="{{ $product->videos->first()->url }}">
                </video>
            @elseif ($product->images->isNotEmpty())
                <div class="flex overflow-x-auto snap-x snap-mandatory h-full no-scrollbar">
                    @foreach ($product->images as $image)
                        <div class="w-full flex-shrink-0 snap-center h-full relative">
                            <img src="{{ $image->url }}" alt="{{ $product->name }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
                @if ($product->images->count() > 1)
                    <div class="absolute bottom-md w-full flex justify-center gap-2">
                        @foreach ($product->images as $image)
                            <div class="h-2 {{ $loop->first ? 'w-6 bg-primary' : 'w-2 bg-on-surface-variant/50' }} rounded-full"></div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="w-full h-full flex items-center justify-center text-outline-variant">
                    <span class="material-symbols-outlined text-[64px]">image</span>
                </div>
            @endif

            <div class="absolute top-md right-md bg-on-background text-primary-container px-sm py-xs rounded-full font-label-bold text-label-bold shadow-lg backdrop-blur-md">
                TZS {{ number_format((float) $product->displayPrice()) }}
            </div>
        </section>

        <div class="px-edge-margin py-md grid gap-md md:grid-cols-3">
            {{-- Left: details --}}
            <div class="md:col-span-2 flex flex-col gap-md">
                <div>
                    <div class="flex items-center gap-xs mb-xs flex-wrap">
                        <span class="bg-tertiary-container/20 text-tertiary font-label-bold text-label-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] filled">{{ $product->availability === 'out_of_stock' ? 'cancel' : 'check_circle' }}</span>
                            {{ $availabilityLabel }}
                        </span>
                        <span class="bg-surface-variant text-on-surface-variant font-label-bold text-label-bold px-2 py-1 rounded-full">
                            {{ $product->category->name }}
                        </span>
                        @if ($product->is_deal)
                            <span class="bg-primary/10 text-primary font-label-bold text-label-bold px-2 py-1 rounded-full">Deal</span>
                        @endif
                    </div>
                    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-background leading-tight mb-xs">
                        {{ $product->name }}
                    </h1>
                    <x-price :price="$product->price" :discount-price="$product->discount_price" size="lg" />
                    @if ($product->location)
                        <p class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-2">
                            <span class="material-symbols-outlined text-[16px]">location_on</span>
                            {{ $product->location }}
                        </p>
                    @endif
                    <p class="font-label-bold text-label-bold text-on-surface-variant mt-1">Ref: {{ $product->reference }}</p>
                </div>

                @if ($product->description)
                    <div class="bg-surface-container-low p-sm rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                        <h2 class="font-title-md text-title-md text-on-surface mb-sm">Description</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                @endif

                @if (! empty($product->specs))
                    <div class="bg-surface-container-low p-sm rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                        <h2 class="font-title-md text-title-md text-on-surface mb-sm flex items-center gap-xs">
                            <span class="material-symbols-outlined">tune</span> Specifications
                        </h2>
                        <div class="grid grid-cols-2 gap-sm">
                            @foreach ($product->specs as $label => $value)
                                <div class="bg-surface p-sm rounded-[1rem] border border-outline-variant/30 flex flex-col justify-center">
                                    <span class="font-label-bold text-label-bold text-secondary mb-1">{{ $label }}</span>
                                    <span class="font-body-lg text-body-lg font-semibold">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: shop card + desktop CTA --}}
            <div class="flex flex-col gap-md">
                <a href="{{ route('shop.show', $product->store) }}" class="bg-surface-container-low p-sm rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.04)] flex items-center gap-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 rounded-full bg-surface-variant overflow-hidden flex-shrink-0 border-2 border-primary-container/20 flex items-center justify-center">
                        @if ($product->store->avatar_path)
                            <img class="w-full h-full object-cover" src="{{ $product->store->avatar_url }}" alt="{{ $product->store->name }}">
                        @else
                            <span class="material-symbols-outlined text-secondary filled">storefront</span>
                        @endif
                    </div>
                    <div class="flex-grow min-w-0">
                        <h3 class="font-title-md text-title-md text-on-background truncate">{{ $product->store->name }}</h3>
                        @if ($product->store->location)
                            <p class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[16px]">location_on</span> {{ $product->store->location }}
                            </p>
                        @endif
                        <p class="font-label-bold text-label-bold text-primary mt-2">Visit shop →</p>
                    </div>
                </a>

                <div class="hidden md:flex flex-col gap-sm">
                    <x-whatsapp-button :product="$product" />
                    <button type="button" data-share data-share-url="{{ route('products.show', $product) }}" data-share-title="{{ $product->name }}"
                            class="w-full border border-outline-variant text-on-surface font-title-md text-title-md py-3 rounded-full flex items-center justify-center gap-2 hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined">share</span>
                        Share
                    </button>
                </div>
            </div>
        </div>

        @if ($moreFromShop->isNotEmpty())
            <div class="px-edge-margin py-md mt-md">
                <h3 class="font-title-md text-title-md text-on-background mb-sm">More from {{ $product->store->name }}</h3>
                <div class="flex overflow-x-auto snap-x snap-mandatory gap-sm pb-sm no-scrollbar">
                    @foreach ($moreFromShop as $item)
                        <a href="{{ route('products.show', $item) }}" class="w-48 flex-shrink-0 snap-start bg-surface-container-lowest rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden">
                            <div class="w-full aspect-square bg-surface-variant">
                                @if ($item->images->first())
                                    <img class="w-full h-full object-cover" src="{{ $item->images->first()->url }}" alt="{{ $item->name }}" loading="lazy">
                                @endif
                            </div>
                            <div class="p-xs">
                                <h4 class="font-body-sm text-body-sm text-on-background line-clamp-1">{{ $item->name }}</h4>
                                <p class="font-label-bold text-label-bold text-primary mt-1">TZS {{ number_format((float) $item->displayPrice()) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($related->isNotEmpty())
            <div class="px-edge-margin py-md">
                <h3 class="font-title-md text-title-md text-on-background mb-sm">You may also like</h3>
                <div class="flex overflow-x-auto snap-x snap-mandatory gap-sm pb-sm no-scrollbar">
                    @foreach ($related as $item)
                        <a href="{{ route('products.show', $item) }}" class="w-48 flex-shrink-0 snap-start bg-surface-container-lowest rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden">
                            <div class="w-full aspect-square bg-surface-variant">
                                @if ($item->images->first())
                                    <img class="w-full h-full object-cover" src="{{ $item->images->first()->url }}" alt="{{ $item->name }}" loading="lazy">
                                @endif
                            </div>
                            <div class="p-xs">
                                <h4 class="font-body-sm text-body-sm text-on-background line-clamp-1">{{ $item->name }}</h4>
                                <p class="font-label-bold text-label-bold text-primary mt-1">TZS {{ number_format((float) $item->displayPrice()) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Fixed mobile CTA --}}
    <div class="md:hidden fixed bottom-md left-edge-margin right-edge-margin z-50 flex gap-sm">
        <x-whatsapp-button :product="$product" class="flex-1" />
        <button type="button" data-share data-share-url="{{ route('products.show', $product) }}" data-share-title="{{ $product->name }}"
                class="w-14 h-14 flex-shrink-0 bg-surface/80 backdrop-blur-md border border-outline-variant rounded-full flex items-center justify-center shadow-lg active:scale-95 transition-all">
            <span class="material-symbols-outlined">share</span>
        </button>
    </div>
</x-layouts.app>
