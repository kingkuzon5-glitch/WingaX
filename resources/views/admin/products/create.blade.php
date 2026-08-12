<x-layouts.admin title="Add Product" active="products">
    <div class="mb-md max-w-4xl mx-auto w-full">
        <h2 class="font-title-md text-title-md md:font-headline-lg md:text-headline-lg text-on-background mb-xs">Add New Product</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Fill in the details below to list your item.</p>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-md max-w-4xl mx-auto w-full">
        @csrf
        @include('admin.products._form', ['product' => null])

        <div class="pt-sm">
            <button type="submit" class="w-full h-16 bg-primary text-on-primary font-title-md text-title-md rounded-full shadow-md hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined filled">save</span>
                Save Product
            </button>
        </div>
    </form>
</x-layouts.admin>
