<x-layouts.admin title="Shop Profile" active="shop">
    <div class="max-w-2xl mx-auto w-full">
        <h2 class="font-title-md text-title-md md:font-headline-lg md:text-headline-lg text-on-background mb-md">Shop Profile</h2>

        <form method="POST" action="{{ route('admin.shop.update') }}" enctype="multipart/form-data"
              class="bg-surface-container-lowest rounded-[24px] p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50 space-y-sm">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-sm">
                <div class="w-20 h-20 rounded-full overflow-hidden bg-surface-variant flex items-center justify-center flex-shrink-0">
                    @if ($store->avatar_url)
                        <img src="{{ $store->avatar_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-secondary text-[32px] filled">storefront</span>
                    @endif
                </div>
                <div class="flex-grow">
                    <label for="avatar" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Shop Logo</label>
                    <input id="avatar" name="avatar" type="file" accept="image/png,image/jpeg,image/webp"
                           class="w-full text-body-sm text-on-surface-variant file:mr-4 file:h-10 file:px-4 file:rounded-full file:border-0 file:bg-primary-container file:text-on-primary-container file:font-label-bold">
                </div>
            </div>
            @error('avatar') <p class="font-body-sm text-body-sm text-error">{{ $message }}</p> @enderror

            <div>
                <label for="cover" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Cover Photo</label>
                @if ($store->cover_url)
                    <img src="{{ $store->cover_url }}" alt="Cover" class="w-full h-24 object-cover rounded-xl mb-2 bg-surface-variant">
                @endif
                <input id="cover" name="cover" type="file" accept="image/png,image/jpeg,image/webp"
                       class="w-full text-body-sm text-on-surface-variant file:mr-4 file:h-10 file:px-4 file:rounded-full file:border-0 file:bg-primary-container file:text-on-primary-container file:font-label-bold">
                @error('cover') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="name" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Shop Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $store->name) }}" required
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                @error('name') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="bio" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">About Your Shop</label>
                <textarea id="bio" name="bio" rows="3" placeholder="Tell customers what you sell..."
                          class="w-full bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background p-4 font-body-lg resize-none">{{ old('bio', $store->bio) }}</textarea>
                @error('bio') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="location" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Location</label>
                <input id="location" name="location" type="text" value="{{ old('location', $store->location) }}" placeholder="e.g., Kariakoo, Dar es Salaam"
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                @error('location') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="whatsapp_number" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">WhatsApp Number</label>
                <input id="whatsapp_number" name="whatsapp_number" type="text" value="{{ old('whatsapp_number', $store->whatsapp_number) }}" required
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Used only for the "Order on WhatsApp" button — never shown publicly.</p>
                @error('whatsapp_number') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="tags_input" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Tags <span class="font-normal">(comma-separated)</span></label>
                <input id="tags_input" name="tags_input" type="text" value="{{ old('tags_input', implode(', ', $store->tags ?? [])) }}" placeholder="e.g., Electronics, Fast Shipping"
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
            </div>

            <button type="submit" class="w-full h-14 bg-primary text-on-primary font-title-md text-title-md rounded-full shadow-md hover:opacity-90 active:scale-[0.98] transition-all">
                Save Shop Profile
            </button>
        </form>
    </div>
</x-layouts.admin>
