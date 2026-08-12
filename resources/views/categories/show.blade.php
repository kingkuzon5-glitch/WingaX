<x-layouts.app :title="$category->name" active-nav="categories" :description="'Shop '.$category->name.' from every seller on WingaX.'" :back-url="route('categories.index')">
    <div class="px-edge-margin md:px-xl max-w-7xl mx-auto py-md md:py-lg">
        <div class="flex items-center gap-2 mb-md">
            <a href="{{ route('categories.index') }}" class="hidden md:flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors font-label-bold text-label-bold">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Categories
            </a>
        </div>
        <h2 class="font-title-md text-title-md md:font-headline-lg md:text-headline-lg mb-sm md:mb-md text-on-surface">{{ $category->name }}</h2>

        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center gap-sm py-xl text-center">
                <span class="material-symbols-outlined text-[64px] text-outline-variant">inventory_2</span>
                <p class="font-title-md text-title-md text-on-surface-variant">No products in this category yet.</p>
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
