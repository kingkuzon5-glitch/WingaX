@php
    $specs = old('spec_labels') ? collect(old('spec_labels'))->combine(old('spec_values')) : collect($product?->specs ?? []);
@endphp

{{-- Basic Info --}}
<div class="bg-surface-container-lowest/80 backdrop-blur-md rounded-[24px] p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50">
    <h3 class="font-title-md text-title-md text-on-background mb-sm">Basic Info</h3>
    <div class="space-y-sm">
        <div>
            <label for="name" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Product Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $product?->name) }}" required placeholder="e.g., Wireless Noise-Cancelling Headphones"
                   class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
            @error('name') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
            <div>
                <label for="price" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Price (TZS)</label>
                <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product?->price) }}" required
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                @error('price') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="discount_price" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Discount Price <span class="font-normal">(optional)</span></label>
                <input id="discount_price" name="discount_price" type="number" step="0.01" min="0" value="{{ old('discount_price', $product?->discount_price) }}"
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                @error('discount_price') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
            <div>
                <label for="category_id" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Category</label>
                <select id="category_id" name="category_id" required
                        class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    <option value="" disabled {{ old('category_id', $product?->category_id) ? '' : 'selected' }}>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="availability" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Availability</label>
                <select id="availability" name="availability" required
                        class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @foreach (['in_stock' => 'In Stock', 'limited' => 'Limited Stock', 'out_of_stock' => 'Out of Stock'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('availability', $product?->availability ?? 'in_stock') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
            <div>
                <label for="location" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Location <span class="font-normal">(optional)</span></label>
                <input id="location" name="location" type="text" value="{{ old('location', $product?->location) }}" placeholder="e.g., Kariakoo, Dar es Salaam"
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
            </div>
            <div>
                <label for="status" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Status</label>
                <select id="status" name="status" required
                        class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    <option value="draft" @selected(old('status', $product?->status ?? 'draft') === 'draft')>Draft (hidden from shoppers)</option>
                    <option value="published" @selected(old('status', $product?->status) === 'published')>Published (visible on WingaX)</option>
                </select>
            </div>
        </div>

        <div>
            <label for="description" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Description</label>
            <textarea id="description" name="description" rows="4" placeholder="Describe your product's features and benefits..."
                      class="w-full bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background p-4 font-body-lg resize-none">{{ old('description', $product?->description) }}</textarea>
        </div>
    </div>
</div>

{{-- Specifications --}}
<div class="bg-surface-container-lowest/80 backdrop-blur-md rounded-[24px] p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50">
    <h3 class="font-title-md text-title-md text-on-background mb-sm">Specifications <span class="font-body-sm text-body-sm text-on-surface-variant font-normal">(optional)</span></h3>
    <div id="specs-rows" class="space-y-2">
        @forelse ($specs as $label => $value)
            <div class="spec-row flex gap-xs items-center">
                <input type="text" name="spec_labels[]" value="{{ $label }}" placeholder="e.g., Storage" class="flex-1 h-12 bg-surface-container-low border-none rounded-xl px-3 font-body-sm">
                <input type="text" name="spec_values[]" value="{{ $value }}" placeholder="e.g., 256GB" class="flex-1 h-12 bg-surface-container-low border-none rounded-xl px-3 font-body-sm">
                <button type="button" class="remove-spec-row p-2 text-secondary hover:text-error" aria-label="Remove"><span class="material-symbols-outlined">close</span></button>
            </div>
        @empty
        @endforelse
    </div>
    <button type="button" id="add-spec-row" class="mt-sm flex items-center gap-1 font-label-bold text-label-bold text-primary hover:opacity-80">
        <span class="material-symbols-outlined text-[18px]">add</span> Add Specification
    </button>
</div>

{{-- Media --}}
<div class="bg-surface-container-lowest/80 backdrop-blur-md rounded-[24px] p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50">
    <h3 class="font-title-md text-title-md text-on-background mb-sm">Media</h3>

    @if ($product?->images->isNotEmpty())
        <div class="grid grid-cols-3 md:grid-cols-4 gap-sm mb-sm">
            @foreach ($product->images as $image)
                <div class="relative aspect-square rounded-xl overflow-hidden bg-surface-variant group">
                    <img src="{{ $image->url }}" alt="" class="w-full h-full object-cover">
                    <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $image]) }}" onsubmit="return confirm('Remove this image?');" class="absolute top-1 right-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-7 h-7 bg-on-background/70 text-white rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <label for="images" class="border-2 border-dashed border-outline-variant rounded-xl p-xl flex flex-col items-center justify-center bg-surface-container-low/50 hover:bg-surface-container-low transition-colors cursor-pointer group">
        <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined" style="font-size: 32px;">cloud_upload</span>
        </div>
        <p class="font-body-lg text-body-lg text-on-background font-semibold">Tap or drag to upload images</p>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2 text-center">Up to 8 images, 5MB each. Vertical (4:5) recommended.</p>
        <input id="images" name="images[]" type="file" accept="image/png,image/jpeg,image/webp" multiple class="sr-only">
    </label>
    @error('images') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
    @error('images.*') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror

    @if ($product?->videos->isNotEmpty())
        <div class="mt-sm flex items-center gap-sm">
            <video src="{{ $product->videos->first()->url }}" class="w-32 h-20 rounded-xl object-cover bg-surface-variant" muted></video>
            <form method="POST" action="{{ route('admin.products.video.destroy', [$product, $product->videos->first()]) }}" onsubmit="return confirm('Remove this video?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="font-label-bold text-label-bold text-error hover:opacity-80">Remove video</button>
            </form>
        </div>
    @endif

    <div class="mt-sm">
        <label for="video" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Product Video <span class="font-normal">(optional, max 50MB)</span></label>
        <input id="video" name="video" type="file" accept="video/mp4,video/webm"
               class="w-full text-body-sm text-on-surface-variant file:mr-4 file:h-11 file:px-4 file:rounded-full file:border-0 file:bg-primary-container file:text-on-primary-container file:font-label-bold">
        @error('video') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
    </div>
</div>

{{-- Settings --}}
<div class="bg-surface-container-lowest/80 backdrop-blur-md rounded-[24px] p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50 space-y-sm">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-title-md text-title-md text-on-background">Featured Product</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Highlight this item on your storefront</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" class="sr-only peer" @checked(old('is_featured', $product?->is_featured))>
            <div class="w-14 h-7 bg-surface-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
        </label>
    </div>
    <div class="flex items-center justify-between pt-sm border-t border-surface-container-high">
        <div>
            <h3 class="font-title-md text-title-md text-on-background">Mark as Deal</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Show this product on the Hot Deals page</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_deal" value="1" class="sr-only peer" @checked(old('is_deal', $product?->is_deal))>
            <div class="w-14 h-7 bg-surface-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
        </label>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('add-spec-row')?.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'spec-row flex gap-xs items-center';
            row.innerHTML = `
                <input type="text" name="spec_labels[]" placeholder="e.g., Storage" class="flex-1 h-12 bg-surface-container-low border-none rounded-xl px-3 font-body-sm">
                <input type="text" name="spec_values[]" placeholder="e.g., 256GB" class="flex-1 h-12 bg-surface-container-low border-none rounded-xl px-3 font-body-sm">
                <button type="button" class="remove-spec-row p-2 text-secondary hover:text-error" aria-label="Remove"><span class="material-symbols-outlined">close</span></button>
            `;
            document.getElementById('specs-rows').appendChild(row);
        });

        document.getElementById('specs-rows')?.addEventListener('click', (event) => {
            if (event.target.closest('.remove-spec-row')) {
                event.target.closest('.spec-row').remove();
            }
        });

        const imagesInput = document.getElementById('images');
        imagesInput?.addEventListener('change', () => {
            const label = imagesInput.closest('label').querySelector('p.font-semibold');
            if (label && imagesInput.files.length > 0) {
                label.textContent = `${imagesInput.files.length} image(s) selected`;
            }
        });
    </script>
@endpush
