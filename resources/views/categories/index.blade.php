<x-layouts.app title="Categories" active-nav="categories" description="Browse WingaX products by category across every shop.">
    <div class="px-edge-margin md:px-xl max-w-7xl mx-auto py-md md:py-lg">
        <h2 class="font-title-md text-title-md md:font-headline-lg md:text-headline-lg mb-sm md:mb-md text-on-surface">Explore Categories</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-gutter md:gap-sm">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="group relative rounded-lg overflow-hidden bg-surface-container-lowest shadow-[0_4px_20px_rgba(0,0,0,0.04)] aspect-square md:aspect-[4/5] flex flex-col items-center justify-center p-sm active:scale-[0.98] transition-transform">
                    <div class="w-16 h-16 md:w-24 md:h-24 mb-sm rounded-full overflow-hidden bg-surface-variant flex items-center justify-center">
                        @if ($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <span class="material-symbols-outlined text-[32px] text-secondary">category</span>
                        @endif
                    </div>
                    <span class="font-title-md text-title-md text-center text-on-surface">{{ $category->name }}</span>
                    <span class="font-label-bold text-label-bold text-on-surface-variant mt-1">{{ $category->products_count }} products</span>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>
