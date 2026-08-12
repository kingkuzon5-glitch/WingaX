<x-layouts.admin title="Products" active="products">
    <div class="mb-lg flex flex-col md:flex-row md:items-center justify-between gap-sm">
        <div>
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-background">Inventory Management</h2>
            <p class="font-body-sm text-body-sm text-secondary mt-1">Manage your active products</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="hidden md:flex items-center gap-1 px-md py-3 rounded-full bg-primary text-on-primary font-label-bold text-label-bold hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-[18px]">add</span> Add Product
        </a>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row gap-sm mb-lg">
        <div class="relative flex-grow">
            <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-secondary">search</span>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name or reference..."
                   class="w-full h-14 pl-12 pr-sm rounded-full bg-surface-container border-none focus:ring-2 focus:ring-primary font-body-lg text-body-lg text-on-surface shadow-inner">
        </div>
        <select name="category" onchange="this.form.submit()" class="h-14 px-4 rounded-full bg-surface-container border-none focus:ring-2 focus:ring-primary font-body-lg text-body-lg text-on-surface">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()" class="h-14 px-4 rounded-full bg-surface-container border-none focus:ring-2 focus:ring-primary font-body-lg text-body-lg text-on-surface">
            <option value="">All Status</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
        </select>
        <button type="submit" class="h-14 px-md rounded-full bg-surface-container-high text-on-surface font-label-bold text-label-bold hover:bg-surface-variant transition-colors">Filter</button>
    </form>

    @if ($products->isEmpty())
        <div class="flex flex-col items-center justify-center gap-sm py-xl text-center">
            <span class="material-symbols-outlined text-[64px] text-outline-variant">inventory_2</span>
            <p class="font-title-md text-title-md text-on-surface-variant">No products found.</p>
            <a href="{{ route('admin.products.create') }}" class="font-label-bold text-label-bold text-primary hover:opacity-80">Add your first product →</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
            @foreach ($products as $product)
                <div class="bg-surface-container-lowest rounded-lg overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] flex flex-col hover:shadow-lg transition-shadow duration-300">
                    <div class="relative h-48 w-full bg-surface-variant">
                        @if ($product->images->first())
                            <img class="w-full h-full object-cover" src="{{ $product->images->first()->url }}" alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-outline-variant">
                                <span class="material-symbols-outlined text-[40px]">image</span>
                            </div>
                        @endif
                        <div class="absolute top-sm right-sm bg-on-background text-primary-container px-3 py-1 rounded-full font-label-bold text-label-bold shadow-md">
                            TZS {{ number_format((float) $product->price) }}
                        </div>
                        <div class="absolute top-sm left-sm {{ $product->status === 'published' ? 'bg-tertiary-container/90 text-on-tertiary-container' : 'bg-surface-variant/90 text-on-surface-variant border border-outline-variant' }} backdrop-blur-sm px-3 py-1 rounded-full font-label-bold text-label-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">{{ $product->status === 'published' ? 'check_circle' : 'edit_note' }}</span>
                            {{ ucfirst($product->status) }}
                        </div>
                    </div>
                    <div class="p-sm flex-1 flex flex-col">
                        <h3 class="font-title-md text-title-md text-on-surface mb-xs line-clamp-1">{{ $product->name }}</h3>
                        <p class="font-body-sm text-body-sm text-secondary mb-md">{{ $product->category->name }} · Ref {{ $product->reference }}</p>
                        <div class="mt-auto pt-sm border-t border-surface-variant flex justify-end gap-xs">
                            <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-secondary hover:text-primary hover:bg-primary-container/10 rounded-full transition-colors">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-secondary hover:text-error hover:bg-error-container/20 rounded-full transition-colors">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-lg">
            {{ $products->links() }}
        </div>
    @endif

    <a href="{{ route('admin.products.create') }}" class="md:hidden fixed bottom-24 right-edge-margin w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg flex items-center justify-center active:scale-95 transition-all z-40">
        <span class="material-symbols-outlined">add</span>
    </a>
</x-layouts.admin>
