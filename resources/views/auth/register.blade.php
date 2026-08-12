<x-layouts.app title="Start Selling" description="Open your free shop on WingaX and start receiving orders on WhatsApp.">
    <div class="min-h-[calc(100vh-8rem)] flex items-center justify-center px-edge-margin py-lg">
        <div class="w-full max-w-[28rem]">
            <div class="text-center mb-lg">
                <a href="{{ route('home') }}" class="font-display-lg text-headline-lg tracking-tighter text-primary">WingaX</a>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">Open your shop in minutes — it's free</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="bg-surface-container-lowest rounded-[24px] p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50 space-y-sm">
                @csrf

                <div>
                    <label for="shop_name" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Shop Name</label>
                    <input id="shop_name" type="text" name="shop_name" value="{{ old('shop_name') }}" required placeholder="e.g., Duka la Mama Amina"
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @error('shop_name')
                        <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="owner_name" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Your Name</label>
                    <input id="owner_name" type="text" name="owner_name" value="{{ old('owner_name') }}" required
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @error('owner_name')
                        <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @error('email')
                        <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="whatsapp_number" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">WhatsApp Number</label>
                    <input id="whatsapp_number" type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required placeholder="e.g., 255712345678"
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @error('whatsapp_number')
                        <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Location <span class="font-normal">(optional)</span></label>
                    <input id="location" type="text" name="location" value="{{ old('location') }}" placeholder="e.g., Kariakoo, Dar es Salaam"
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @error('location')
                        <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @error('password')
                        <p class="font-body-sm text-body-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                </div>

                <button type="submit" class="w-full h-14 bg-primary text-on-primary font-title-md text-title-md rounded-full shadow-md hover:opacity-90 active:scale-[0.98] transition-all">
                    Create my shop
                </button>
            </form>

            <p class="text-center font-body-sm text-body-sm text-on-surface-variant mt-md">
                Already selling on WingaX?
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:opacity-80">Log in</a>
            </p>
        </div>
    </div>
</x-layouts.app>
