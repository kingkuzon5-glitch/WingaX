@props([
    'title' => null,
    'description' => 'WingaX — discover products from your favourite Tanzanian seller and order instantly on WhatsApp.',
    'ogImage' => null,
    'activeNav' => 'home',
    'backUrl' => null,
    'fullBleed' => false,
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title.' · WingaX' : 'WingaX — Discover. Order. WhatsApp.' }}</title>
    <meta name="description" content="{{ $description }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ? $title.' · WingaX' : 'WingaX' }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL@20..48,100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}
</head>
<body class="bg-background text-on-background font-body-lg antialiased min-h-screen">

    <header class="hidden md:flex bg-surface/70 backdrop-blur-xl fixed top-0 w-full z-50 shadow-sm items-center justify-between px-edge-margin h-16">
        <div class="flex items-center gap-sm">
            <a href="{{ route('home') }}" class="font-display-lg text-headline-lg tracking-tighter text-primary">WingaX</a>
        </div>
        <form action="{{ route('search.index') }}" method="GET" class="flex-1 max-w-[36rem] px-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-secondary">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products, categories..."
                       class="w-full bg-surface-container-high border-none rounded-full py-3 pl-12 pr-4 font-body-lg text-body-lg text-on-surface placeholder-secondary focus:ring-2 focus:ring-primary-container outline-none h-12">
            </div>
        </form>
        <nav class="flex gap-md items-center">
            <a href="{{ route('home') }}" class="font-label-bold text-label-bold {{ $activeNav === 'home' ? 'text-primary' : 'text-on-surface-variant' }} hover:opacity-80 transition-opacity">Home</a>
            <a href="{{ route('categories.index') }}" class="font-label-bold text-label-bold {{ $activeNav === 'categories' ? 'text-primary' : 'text-on-surface-variant' }} hover:opacity-80 transition-opacity">Categories</a>
            <a href="{{ route('deals.index') }}" class="font-label-bold text-label-bold {{ $activeNav === 'deals' ? 'text-primary' : 'text-on-surface-variant' }} hover:opacity-80 transition-opacity">Deals</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="font-label-bold text-label-bold bg-primary text-on-primary px-sm py-2 rounded-full hover:opacity-90 transition-opacity">My Shop</a>
            @else
                <a href="{{ route('register') }}" class="font-label-bold text-label-bold bg-primary text-on-primary px-sm py-2 rounded-full hover:opacity-90 transition-opacity">Sell on WingaX</a>
            @endauth
        </nav>
    </header>

    <header class="md:hidden fixed top-0 w-full z-50 flex items-center justify-between px-edge-margin h-16 {{ $fullBleed ? 'pointer-events-none' : 'bg-surface/70 backdrop-blur-xl shadow-sm' }}">
        @if ($backUrl)
            <a href="{{ $backUrl }}" class="text-on-surface-variant hover:opacity-80 active:scale-95 transition-all p-2 -ml-2 pointer-events-auto {{ $fullBleed ? 'bg-surface/60 backdrop-blur-md rounded-full' : '' }}" aria-label="Go back">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
        @else
            <a href="{{ route('home') }}" class="p-2 -ml-2 pointer-events-auto"></a>
        @endif
        <span class="font-display-lg text-headline-lg-mobile tracking-tighter text-primary drop-shadow-sm">WingaX</span>
        <div class="w-10"></div>
    </header>

    <main class="{{ $fullBleed ? '' : 'pt-16 pb-24 md:pb-0 md:pt-16' }}">
        {{ $slot }}
    </main>

    <nav class="md:hidden bg-surface/70 backdrop-blur-xl fixed bottom-0 w-full z-50 rounded-t-lg shadow-[0_-4px_20px_rgba(0,0,0,0.04)] flex justify-around items-center pt-xs pb-safe px-gutter">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center {{ $activeNav === 'home' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1 active:scale-90 transition-all duration-200">
            <span class="material-symbols-outlined {{ $activeNav === 'home' ? 'filled' : '' }}">home</span>
            <span class="font-label-bold text-label-bold mt-1">Home</span>
        </a>
        <a href="{{ route('categories.index') }}" class="flex flex-col items-center justify-center {{ $activeNav === 'categories' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1 active:scale-90 transition-all duration-200">
            <span class="material-symbols-outlined {{ $activeNav === 'categories' ? 'filled' : '' }}">grid_view</span>
            <span class="font-label-bold text-label-bold mt-1">Categories</span>
        </a>
        <a href="{{ route('search.index') }}" class="flex flex-col items-center justify-center {{ $activeNav === 'search' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1 active:scale-90 transition-all duration-200">
            <span class="material-symbols-outlined {{ $activeNav === 'search' ? 'filled' : '' }}">search</span>
            <span class="font-label-bold text-label-bold mt-1">Search</span>
        </a>
        <a href="{{ route('deals.index') }}" class="flex flex-col items-center justify-center {{ $activeNav === 'deals' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1 active:scale-90 transition-all duration-200">
            <span class="material-symbols-outlined {{ $activeNav === 'deals' ? 'filled' : '' }}">local_offer</span>
            <span class="font-label-bold text-label-bold mt-1">Deals</span>
        </a>
        @auth
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center {{ $activeNav === 'sell' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1 active:scale-90 transition-all duration-200">
                <span class="material-symbols-outlined">storefront</span>
                <span class="font-label-bold text-label-bold mt-1">My Shop</span>
            </a>
        @else
            <a href="{{ route('register') }}" class="flex flex-col items-center justify-center {{ $activeNav === 'sell' ? 'bg-primary-container text-on-primary-container' : 'text-secondary' }} rounded-xl px-xs py-1 active:scale-90 transition-all duration-200">
                <span class="material-symbols-outlined">storefront</span>
                <span class="font-label-bold text-label-bold mt-1">Sell</span>
            </a>
        @endauth
    </nav>

    @stack('scripts')
</body>
</html>
