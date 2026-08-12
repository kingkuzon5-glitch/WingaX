<x-layouts.admin title="Categories" active="categories">
    <div class="mb-lg flex flex-col md:flex-row md:items-center justify-between gap-sm">
        <div>
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-background">Categories</h2>
            <p class="font-body-sm text-body-sm text-secondary mt-1">Shared across every shop on WingaX</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="flex items-center justify-center gap-1 px-md py-3 rounded-full bg-primary text-on-primary font-label-bold text-label-bold hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-[18px]">add</span> Add Category
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-gutter md:gap-sm">
        @foreach ($categories as $category)
            <div class="bg-surface-container-lowest rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden">
                <div class="aspect-square bg-surface-variant flex items-center justify-center">
                    @if ($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-[40px] text-secondary">category</span>
                    @endif
                </div>
                <div class="p-sm">
                    <h3 class="font-title-md text-title-md text-on-surface line-clamp-1">{{ $category->name }}</h3>
                    <p class="font-body-sm text-body-sm text-secondary mb-sm">{{ $category->products_count }} products</p>
                    <div class="flex justify-end gap-xs">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 text-secondary hover:text-primary hover:bg-primary-container/10 rounded-full transition-colors">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-secondary hover:text-error hover:bg-error-container/20 rounded-full transition-colors">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.admin>
