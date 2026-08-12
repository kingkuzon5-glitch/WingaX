<x-layouts.admin title="Edit Category" active="categories">
    <div class="max-w-[32rem] mx-auto w-full">
        <h2 class="font-title-md text-title-md md:font-headline-lg md:text-headline-lg text-on-background mb-md">Edit Category</h2>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data"
              class="bg-surface-container-lowest rounded-[24px] p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50 space-y-sm">
            @csrf
            @method('PUT')

            @if ($category->image)
                <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="w-24 h-24 rounded-xl object-cover bg-surface-variant">
            @endif

            <div>
                <label for="name" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Category Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required
                       class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                @error('name') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="image" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Replace Image <span class="font-normal">(optional)</span></label>
                <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp"
                       class="w-full text-body-sm text-on-surface-variant file:mr-4 file:h-11 file:px-4 file:rounded-full file:border-0 file:bg-primary-container file:text-on-primary-container file:font-label-bold">
                @error('image') <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full h-14 bg-primary text-on-primary font-title-md text-title-md rounded-full shadow-md hover:opacity-90 active:scale-[0.98] transition-all">
                Save Changes
            </button>
        </form>
    </div>
</x-layouts.admin>
