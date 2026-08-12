<x-layouts.app :title="$store->name" :description="Str::limit(strip_tags($store->bio ?? $store->name.' on WingaX'), 150)"
    :og-image="$store->cover_url" :back-url="route('home')">
    <div class="w-full max-w-5xl mx-auto pb-24 md:pb-xl">
        <div class="relative w-full h-40 md:h-56 bg-surface-variant {{ $store->cover_url ? '' : 'bg-gradient-to-br from-primary to-primary-container' }}">
            @if ($store->cover_url)
                <img src="{{ $store->cover_url }}" alt="{{ $store->name }} cover" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-background/80 to-transparent"></div>
        </div>

        <div class="px-edge-margin">
            <div class="flex items-end gap-sm mb-md">
                <div class="w-24 h-24 -mt-12 rounded-full border-4 border-background bg-surface-container-lowest overflow-hidden flex items-center justify-center shadow-lg flex-shrink-0">
                    @if ($store->avatar_url)
                        <img src="{{ $store->avatar_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-[40px] text-secondary">storefront</span>
                    @endif
                </div>
                <div class="pb-2 min-w-0">
                    <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-on-background flex items-center gap-1 truncate">
                        {{ $store->name }}
                        <span class="material-symbols-outlined text-tertiary-container text-[18px] filled">verified</span>
                    </h1>
                    @if ($store->location)
                        <p class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-1">
                            <span class="material-symbols-outlined text-[16px]">location_on</span> {{ $store->location }}
                        </p>
                    @endif
                </div>
            </div>

            @if ($store->bio)
                <section class="mb-md">
                    <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">{{ $store->bio }}</p>
                </section>
            @endif

            @if (! empty($store->tags))
                <section class="mb-md flex flex-wrap gap-xs">
                    @foreach ($store->tags as $tag)
                        <span class="px-sm py-xs bg-surface-container-highest border border-outline-variant/30 rounded-full font-label-bold text-label-bold text-on-surface-variant">{{ $tag }}</span>
                    @endforeach
                </section>
            @endif

            <section class="grid grid-cols-3 gap-sm mb-lg">
                <div class="bg-surface-container-low p-sm rounded-lg text-center">
                    <div class="font-title-md text-title-md text-primary">{{ $stats['products'] }}</div>
                    <div class="font-label-bold text-label-bold text-secondary">Products</div>
                </div>
                <div class="bg-surface-container-low p-sm rounded-lg text-center">
                    <div class="font-title-md text-title-md text-primary">{{ $stats['categories'] }}</div>
                    <div class="font-label-bold text-label-bold text-secondary">Categories</div>
                </div>
                <div class="bg-surface-container-low p-sm rounded-lg text-center">
                    <div class="font-title-md text-title-md text-primary">{{ $stats['memberSince']?->format('M Y') ?? '—' }}</div>
                    <div class="font-label-bold text-label-bold text-secondary">Since</div>
                </div>
            </section>

            <h2 class="font-title-md text-title-md text-on-surface mb-sm">Products</h2>

            @if ($products->isEmpty())
                <div class="flex flex-col items-center justify-center gap-sm py-xl text-center">
                    <span class="material-symbols-outlined text-[64px] text-outline-variant">inventory_2</span>
                    <p class="font-title-md text-title-md text-on-surface-variant">This shop hasn't listed any products yet.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 gap-gutter md:gap-sm">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-lg">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
