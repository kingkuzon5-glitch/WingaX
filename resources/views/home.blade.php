<x-layouts.app title="Home" active-nav="home" :full-bleed="true">
    {{-- Mobile: TikTok-style vertical snap feed --}}
    <div class="md:hidden h-screen w-full snap-y snap-mandatory overflow-y-scroll no-scrollbar" id="feed-container" data-more-url="{{ route('feed.more') }}">
        @forelse ($products as $product)
            <x-feed-item :product="$product" />
        @empty
            <section class="h-screen w-full flex flex-col items-center justify-center gap-sm px-edge-margin text-center">
                <span class="material-symbols-outlined text-[64px] text-outline-variant">inventory_2</span>
                <p class="font-title-md text-title-md text-on-surface-variant">No products yet. Check back soon!</p>
            </section>
        @endforelse

        @if ($products->hasMorePages())
            <div id="feed-sentinel" data-cursor="{{ $products->nextCursor()?->encode() }}"></div>
        @endif
    </div>

    {{-- Desktop: hero + bento discovery grid --}}
    <div class="hidden md:grid pt-24 pb-xl px-edge-margin max-w-[1600px] mx-auto md:grid-cols-1 lg:grid-cols-[280px_1fr_320px] gap-lg">
        <aside class="hidden lg:flex lg:flex-col h-full py-md pr-sm border-r border-outline-variant shadow-md bg-surface-container-lowest rounded-lg overflow-hidden sticky top-24 self-start max-h-[calc(100vh-120px)]">
            <div class="px-md pb-md mb-md border-b border-surface-container-high">
                <h2 class="font-title-md text-title-md text-on-surface">Browse Categories</h2>
            </div>
            <nav class="flex-1 overflow-y-auto px-xs">
                <ul class="space-y-1">
                    @foreach (\App\Models\Category::orderBy('name')->get() as $category)
                        <li>
                            <a href="{{ route('categories.show', $category) }}"
                               class="flex items-center gap-sm px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-r-full transition-colors font-body-lg text-body-lg">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </aside>

        <div class="flex flex-col gap-lg w-full max-w-4xl mx-auto">
            @if ($desktopHighlights->isNotEmpty())
                @php $hero = $desktopHighlights->first(); @endphp
                <a href="{{ route('products.show', $hero) }}" class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] flex flex-col group">
                    <div class="relative w-full aspect-video bg-surface-container overflow-hidden">
                        @if ($hero->images->first())
                            <img src="{{ $hero->images->first()->url }}" alt="{{ $hero->name }}" loading="eager"
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        @endif
                        <div class="absolute top-md right-md bg-on-surface text-primary-container font-title-md text-title-md px-sm py-1 rounded-full shadow-lg">
                            TZS {{ number_format((float) $hero->displayPrice()) }}
                        </div>
                    </div>
                    <div class="p-md flex flex-col gap-sm">
                        <h3 class="font-headline-lg text-headline-lg tracking-tight text-on-surface">{{ $hero->name }}</h3>
                        <span class="font-label-bold text-label-bold text-on-surface-variant flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">storefront</span>
                            {{ $hero->store->name }}
                        </span>
                        @if ($hero->description)
                            <p class="font-body-lg text-body-lg text-on-surface-variant">{{ Str::limit($hero->description, 140) }}</p>
                        @endif
                    </div>
                </a>

                @if ($desktopHighlights->skip(1)->isNotEmpty())
                    <section class="grid grid-cols-2 gap-sm">
                        @foreach ($desktopHighlights->skip(1)->take(4) as $item)
                            <a href="{{ route('products.show', $item) }}" class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] aspect-square relative group">
                                @if ($item->images->first())
                                    <img src="{{ $item->images->first()->url }}" alt="{{ $item->name }}" loading="lazy"
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-md">
                                    <h4 class="font-title-md text-title-md text-white">{{ $item->name }}</h4>
                                    <p class="font-body-sm text-body-sm text-surface-container-low opacity-90">TZS {{ number_format((float) $item->displayPrice()) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </section>
                @endif
            @else
                <p class="font-title-md text-title-md text-on-surface-variant">No products yet. Check back soon!</p>
            @endif
        </div>

        <aside class="hidden lg:flex lg:flex-col gap-md sticky top-24 self-start max-h-[calc(100vh-120px)] w-full">
            <div class="bg-surface-container-lowest rounded-xl p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low">
                @auth
                    <h3 class="font-title-md text-title-md text-on-surface mb-sm">Your Shop</h3>
                    <p class="font-body-sm text-body-sm text-secondary mb-4 leading-relaxed">Manage your products, track WhatsApp leads, and grow your shop on WingaX.</p>
                    <a href="{{ route('admin.dashboard') }}" class="font-label-bold text-label-bold text-primary hover:opacity-80 transition-opacity">Go to dashboard →</a>
                @else
                    <h3 class="font-title-md text-title-md text-on-surface mb-sm">Sell on WingaX</h3>
                    <p class="font-body-sm text-body-sm text-secondary mb-4 leading-relaxed">Open your own shop in minutes and start receiving orders on WhatsApp — free to get started.</p>
                    <a href="{{ route('register') }}" class="font-label-bold text-label-bold text-primary hover:opacity-80 transition-opacity">Start selling →</a>
                @endauth
            </div>
        </aside>
    </div>

    @push('scripts')
        @vite('resources/js/feed.js')
    @endpush
</x-layouts.app>
