<x-layouts.app title="Search" active-nav="search" description="Search products across every WingaX shop.">
    <div class="px-edge-margin md:px-xl max-w-7xl mx-auto py-md md:py-lg flex flex-col gap-md">
        <form action="{{ route('search.index') }}" method="GET" class="w-full">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input type="text" name="q" value="{{ $q }}" placeholder="Search products..." autofocus
                       class="w-full h-14 pl-12 pr-4 rounded-full bg-surface-container-high border-none focus:ring-2 focus:ring-primary text-on-surface font-body-lg placeholder-on-surface-variant/70 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
            </div>
        </form>

        @if ($q === '')
            @if ($popularCategories->isNotEmpty())
                <section>
                    <h2 class="font-title-md text-title-md text-on-surface mb-sm">Popular Categories</h2>
                    <div class="flex flex-wrap gap-xs">
                        @foreach ($popularCategories as $category)
                            <a href="{{ route('categories.show', $category) }}"
                               class="px-sm py-xs bg-surface-container-highest border border-outline-variant/30 rounded-full font-label-bold text-label-bold text-on-surface-variant hover:bg-surface-variant/50 transition-colors shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="recent-searches-section" class="hidden">
                <div class="flex justify-between items-center mb-sm">
                    <h2 class="font-title-md text-title-md text-on-surface">Recent</h2>
                    <button type="button" id="clear-recent-searches" class="font-label-bold text-label-bold text-primary hover:opacity-80">Clear</button>
                </div>
                <ul id="recent-searches-list" class="flex flex-col gap-xs"></ul>
            </section>
        @else
            <section>
                <h2 class="font-title-md text-title-md text-on-surface mb-sm">
                    Results for "{{ $q }}"
                    @if ($products->total() > 0)
                        <span class="text-on-surface-variant font-body-sm text-body-sm">({{ $products->total() }})</span>
                    @endif
                </h2>

                @if ($products->isEmpty())
                    <div class="flex flex-col items-center justify-center gap-sm py-xl text-center">
                        <span class="material-symbols-outlined text-[64px] text-outline-variant">search_off</span>
                        <p class="font-title-md text-title-md text-on-surface-variant">No products found for "{{ $q }}"</p>
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
            </section>
        @endif
    </div>

    @push('scripts')
        @vite('resources/js/search.js')
    @endpush
</x-layouts.app>
