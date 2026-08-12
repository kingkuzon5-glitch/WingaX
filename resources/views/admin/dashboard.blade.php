<x-layouts.admin title="Dashboard" active="dashboard">
    <div class="mb-md flex flex-col md:flex-row md:items-center justify-between gap-sm">
        <div>
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-background">Overview</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Welcome back, {{ auth()->user()->store->name }}</p>
        </div>
        <div class="hidden md:flex gap-sm">
            <a href="{{ route('admin.products.index') }}" class="px-md py-3 rounded-full border border-outline-variant text-on-surface font-label-bold text-label-bold hover:bg-surface-container-high transition-colors">
                Manage Products
            </a>
            <a href="{{ route('admin.products.create') }}" class="px-md py-3 rounded-full bg-primary text-on-primary font-label-bold text-label-bold hover:opacity-90 transition-opacity flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">add</span> Add New Product
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-sm mb-md">
        <x-admin.stat-card label="Total Product Views" :value="number_format($stats['total_views'])" icon="visibility" :change="$stats['total_views_change']" />
        <x-admin.stat-card label="WhatsApp Leads" :value="number_format($stats['total_clicks'])" icon="chat" :change="$stats['total_clicks_change']" />
        <x-admin.stat-card label="Active Deals" :value="$stats['active_deals']" icon="local_offer" />
    </div>

    <div class="md:hidden flex flex-col gap-sm mb-md">
        <a href="{{ route('admin.products.create') }}" class="w-full h-14 bg-primary text-on-primary font-title-md text-title-md rounded-full flex items-center justify-center gap-2 shadow-md active:scale-[0.98] transition-all">
            <span class="material-symbols-outlined">add</span> Add New Product
        </a>
        <a href="{{ route('admin.products.index') }}" class="w-full h-14 border border-outline-variant text-on-surface font-title-md text-title-md rounded-full flex items-center justify-center gap-2 active:scale-[0.98] transition-all">
            Manage Products
        </a>
    </div>

    <div class="bg-surface-container-lowest rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low p-sm md:p-md">
        <div class="flex justify-between items-center mb-sm">
            <h3 class="font-title-md text-title-md text-on-surface">Recent Leads (WhatsApp)</h3>
            <a href="{{ route('admin.analytics') }}" class="font-label-bold text-label-bold text-primary hover:opacity-80">View All</a>
        </div>

        @if ($recentLeads->isEmpty())
            <p class="font-body-sm text-body-sm text-on-surface-variant py-md text-center">No WhatsApp leads yet. Once customers tap "Order on WhatsApp" on your products, they'll show up here.</p>
        @else
            <ul class="divide-y divide-surface-container-high">
                @foreach ($recentLeads as $lead)
                    <li class="flex items-center gap-sm py-sm">
                        <div class="w-12 h-12 rounded-lg bg-surface-variant overflow-hidden flex-shrink-0 flex items-center justify-center">
                            @if ($lead->product?->images->first())
                                <img class="w-full h-full object-cover" src="{{ $lead->product->images->first()->url }}" alt="{{ $lead->product->name }}">
                            @else
                                <span class="material-symbols-outlined text-secondary">image</span>
                            @endif
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="font-body-lg text-body-lg text-on-surface truncate">{{ $lead->product->name ?? 'Deleted product' }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Inquired {{ $lead->created_at->diffForHumans() }}</p>
                        </div>
                        @if ($lead->product)
                            <a href="{{ route('admin.products.edit', $lead->product) }}" class="p-2 text-secondary hover:text-primary rounded-full hover:bg-primary-container/10 transition-colors">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.admin>
