<x-layouts.app title="Login" description="Log in to your WingaX seller dashboard.">
    <div class="min-h-[calc(100vh-8rem)] flex items-center justify-center px-edge-margin py-lg">
        <div class="w-full max-w-[28rem]">
            <div class="text-center mb-lg">
                <a href="{{ route('home') }}" class="font-display-lg text-headline-lg tracking-tighter text-primary">WingaX</a>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">Log in to manage your shop</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}" class="bg-surface-container-lowest rounded-[24px] p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-variant/50 space-y-sm">
                @csrf

                <div>
                    <label for="email" class="block font-label-bold text-label-bold text-on-surface-variant mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full h-14 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary text-on-background px-4 font-body-lg">
                    @error('email')
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

                <label class="flex items-center gap-2 font-body-sm text-body-sm text-on-surface-variant">
                    <input type="checkbox" name="remember" class="rounded border-outline-variant text-primary focus:ring-primary">
                    Remember me
                </label>

                <button type="submit" class="w-full h-14 bg-primary text-on-primary font-title-md text-title-md rounded-full shadow-md hover:opacity-90 active:scale-[0.98] transition-all">
                    Log in
                </button>
            </form>

            <p class="text-center font-body-sm text-body-sm text-on-surface-variant mt-md">
                New to WingaX?
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:opacity-80">Start selling</a>
            </p>
        </div>
    </div>
</x-layouts.app>
