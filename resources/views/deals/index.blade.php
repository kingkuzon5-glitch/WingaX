<x-layouts.app title="Hot Deals" active-nav="deals" description="Discounted products from sellers across WingaX.">
    <div class="px-edge-margin md:px-xl max-w-7xl mx-auto py-md md:py-lg">
        <section class="mb-md">
            <div class="relative w-full h-40 md:h-56 rounded-xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] bg-gradient-to-br from-primary to-primary-container flex items-center">
                <div class="p-md md:p-lg">
                    <h2 class="font-title-md text-title-md md:font-headline-lg md:text-headline-lg text-on-primary mb-xs">Hot Deals</h2>
                    <p class="font-body-sm text-body-sm text-on-primary/90 max-w-[20rem]">Discounted products from sellers across WingaX. Grab them before they're gone.</p>
                </div>
                <div class="absolute top-sm right-sm bg-on-background text-primary-container font-label-bold text-label-bold px-sm py-xs rounded-full shadow-md">
                    HOT DEALS
                </div>
            </div>
        </section>

        @if ($categories->isNotEmpty())
            <section class="mb-md overflow-x-auto pb-sm no-scrollbar">
                <div class="flex gap-sm w-max">
                    <a href="{{ route('deals.index') }}"
                       class="{{ request('category') ? 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/50' : 'bg-primary text-on-primary border-transparent' }} font-label-bold text-label-bold px-md py-xs rounded-full transition-colors border shadow-sm">
                        All Deals
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('deals.index', ['category' => $category->slug]) }}"
                           class="{{ request('category') === $category->slug ? 'bg-primary text-on-primary border-transparent' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/50' }} font-label-bold text-label-bold px-md py-xs rounded-full transition-colors border shadow-sm">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center gap-sm py-xl text-center">
                <span class="material-symbols-outlined text-[64px] text-outline-variant">local_offer</span>
                <p class="font-title-md text-title-md text-on-surface-variant">No deals right now — check back soon!</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-gutter md:gap-sm">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-lg">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
