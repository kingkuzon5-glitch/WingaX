@props([
    'title' => null,
    'active' => 'dashboard',
])

@php $store = auth()->user()->store; @endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ? $title.' · WingaX Admin' : 'WingaX Admin' }}</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL@20..48,100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background font-body-lg antialiased min-h-screen flex flex-col md:flex-row">

    <aside class="hidden md:flex flex-col h-screen py-md pr-sm bg-surface-container-lowest border-r border-outline-variant shadow-md w-72 flex-shrink-0 sticky top-0">
        <div class="px-md mb-8">
            <a href="{{ route('admin.dashboard') }}" class="font-display-lg text-headline-lg text-primary mb-6 block">WingaX</a>
            <div class="flex items-center gap-4 p-4 rounded-xl bg-surface-variant/30">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-variant flex items-center justify-center flex-shrink-0">
                    @if ($store->avatar_path)
                        <img class="w-full h-full object-cover" src="{{ $store->avatar_url }}" alt="{{ $store->name }}">
                    @else
                        <span class="material-symbols-outlined text-secondary filled">storefront</span>
                    @endif
                </div>
                <div class="min-w-0">
                    <div class="font-title-md text-title-md text-on-surface truncate">{{ $store->name }}</div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant truncate">{{ auth()->user()?->email }}</div>
                </div>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto pr-2">
            <ul class="space-y-2">
                <x-admin.nav-link :href="route('admin.dashboard')" icon="dashboard" :active="$active === 'dashboard'">Dashboard</x-admin.nav-link>
                <x-admin.nav-link :href="route('admin.products.index')" icon="inventory_2" :active="$active === 'products'">Products</x-admin.nav-link>
                <x-admin.nav-link :href="route('admin.categories.index')" icon="category" :active="$active === 'categories'">Categories</x-admin.nav-link>
                <x-admin.nav-link :href="route('admin.analytics')" icon="analytics" :active="$active === 'analytics'">Analytics</x-admin.nav-link>
                <x-admin.nav-link :href="route('admin.shop.edit')" icon="storefront" :active="$active === 'shop'">Shop Profile</x-admin.nav-link>
            </ul>
        </nav>
        <div class="px-md pt-md border-t border-surface-container-high">
            <a href="{{ route('shop.show', $store) }}" target="_blank" class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-body-sm text-body-sm mb-3">
                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                View my shop
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-error hover:opacity-80 transition-opacity font-body-sm text-body-sm">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Log out
                </button>
            </form>
        </div>
    </aside>

    <header class="md:hidden fixed top-0 w-full z-50 bg-surface/70 backdrop-blur-xl shadow-sm flex items-center justify-between px-edge-margin h-16">
        <a href="{{ route('admin.dashboard') }}" class="font-display-lg text-headline-lg-mobile tracking-tighter text-primary">WingaX</a>
        <div class="flex items-center gap-1">
            <a href="{{ route('admin.shop.edit') }}" class="text-on-surface-variant p-2 rounded-full hover:bg-surface-variant/50" aria-label="Shop profile">
                <span class="material-symbols-outlined">storefront</span>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-on-surface-variant p-2 rounded-full hover:bg-surface-variant/50" aria-label="Log out">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </div>
    </header>

    <nav class="md:hidden fixed bottom-0 w-full z-50 bg-surface/70 backdrop-blur-xl shadow-[0_-4px_20px_rgba(0,0,0,0.04)] flex justify-around items-center pt-xs pb-safe px-gutter">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center {{ $active === 'dashboard' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-bold text-label-bold mt-1">Dashboard</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="flex flex-col items-center justify-center {{ $active === 'products' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-label-bold text-label-bold mt-1">Products</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="flex flex-col items-center justify-center {{ $active === 'categories' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1">
            <span class="material-symbols-outlined">category</span>
            <span class="font-label-bold text-label-bold mt-1">Categories</span>
        </a>
        <a href="{{ route('admin.analytics') }}" class="flex flex-col items-center justify-center {{ $active === 'analytics' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-label-bold text-label-bold mt-1">Analytics</span>
        </a>
    </nav>

    <main class="flex-1 pt-20 md:pt-md pb-24 md:pb-lg px-edge-margin md:px-xl max-w-7xl mx-auto w-full">
        @if (session('status'))
            <div class="mb-md p-sm rounded-xl bg-tertiary-container/10 text-tertiary font-body-sm text-body-sm border border-tertiary-container/30">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-md p-sm rounded-xl bg-error-container/40 text-on-error-container font-body-sm text-body-sm border border-error/30">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </main>

</body>
</html>
