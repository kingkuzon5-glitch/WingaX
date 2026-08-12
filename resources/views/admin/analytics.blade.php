@php
    $maxTrendValue = max(1, collect($trend)->flatMap(fn ($d) => [$d['views'], $d['clicks']])->max());
    $chartWidth = 320;
    $chartHeight = 120;
    $stepX = $chartWidth / max(1, count($trend) - 1);

    $viewsPoints = collect($trend)->values()->map(function ($day, $i) use ($stepX, $chartHeight, $maxTrendValue) {
        $x = round($i * $stepX, 1);
        $y = round($chartHeight - ($day['views'] / $maxTrendValue) * $chartHeight, 1);
        return "{$x},{$y}";
    })->implode(' ');

    $clicksPoints = collect($trend)->values()->map(function ($day, $i) use ($stepX, $chartHeight, $maxTrendValue) {
        $x = round($i * $stepX, 1);
        $y = round($chartHeight - ($day['clicks'] / $maxTrendValue) * $chartHeight, 1);
        return "{$x},{$y}";
    })->implode(' ');
@endphp

<x-layouts.admin title="Analytics" active="analytics">
    <div class="mb-lg">
        <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-background">Analytics</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Performance for your shop</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-sm mb-md">
        <x-admin.stat-card label="Total Views" :value="number_format($totalViews)" icon="visibility" />
        <x-admin.stat-card label="WhatsApp Clicks" :value="number_format($totalClicks)" icon="chat" />
        <x-admin.stat-card label="Conversion Rate" :value="$conversionRate.'%'" icon="trending_up" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-md">
        {{-- Engagement trend --}}
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-lg p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low">
            <div class="flex items-center justify-between mb-sm">
                <h3 class="font-title-md text-title-md text-on-surface">Engagement Trend (7 days)</h3>
                <div class="flex items-center gap-md font-label-bold text-label-bold">
                    <span class="flex items-center gap-1 text-primary"><span class="w-2 h-2 rounded-full bg-primary inline-block"></span> Views</span>
                    <span class="flex items-center gap-1 text-tertiary"><span class="w-2 h-2 rounded-full bg-tertiary inline-block"></span> Clicks</span>
                </div>
            </div>

            <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" class="w-full h-40" preserveAspectRatio="none">
                <polyline points="{{ $viewsPoints }}" fill="none" stroke="var(--color-primary)" stroke-width="2.5" vector-effect="non-scaling-stroke" />
                <polyline points="{{ $clicksPoints }}" fill="none" stroke="var(--color-tertiary)" stroke-width="2.5" vector-effect="non-scaling-stroke" />
            </svg>
            <div class="flex justify-between mt-2">
                @foreach ($trend as $day)
                    <span class="font-label-bold text-label-bold text-on-surface-variant">{{ $day['label'] }}</span>
                @endforeach
            </div>
        </div>

        {{-- Top categories --}}
        <div class="bg-surface-container-lowest rounded-lg p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low">
            <h3 class="font-title-md text-title-md text-on-surface mb-sm">Top Categories</h3>
            @if (empty($topCategories))
                <p class="font-body-sm text-body-sm text-on-surface-variant">No view data yet.</p>
            @else
                <div class="space-y-sm">
                    @foreach ($topCategories as $cat)
                        <div>
                            <div class="flex justify-between font-label-bold text-label-bold text-on-surface mb-1">
                                <span>{{ $cat['name'] }}</span>
                                <span>{{ $cat['percent'] }}%</span>
                            </div>
                            <div class="h-2 rounded-full bg-surface-container-high overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: {{ $cat['percent'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-md mt-md">
        <div class="bg-surface-container-lowest rounded-lg p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low">
            <h3 class="font-title-md text-title-md text-on-surface mb-sm">Most Viewed Products</h3>
            @if ($mostViewed->isEmpty())
                <p class="font-body-sm text-body-sm text-on-surface-variant">No views yet.</p>
            @else
                <ul class="divide-y divide-surface-container-high">
                    @foreach ($mostViewed as $product)
                        <li class="flex items-center justify-between py-2">
                            <span class="font-body-sm text-body-sm text-on-surface line-clamp-1">{{ $product->name }}</span>
                            <span class="font-label-bold text-label-bold text-primary">{{ $product->views_count }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-surface-container-lowest rounded-lg p-sm md:p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low">
            <h3 class="font-title-md text-title-md text-on-surface mb-sm">Most WhatsApp Clicks</h3>
            @if ($mostClicked->isEmpty())
                <p class="font-body-sm text-body-sm text-on-surface-variant">No clicks yet.</p>
            @else
                <ul class="divide-y divide-surface-container-high">
                    @foreach ($mostClicked as $product)
                        <li class="flex items-center justify-between py-2">
                            <span class="font-body-sm text-body-sm text-on-surface line-clamp-1">{{ $product->name }}</span>
                            <span class="font-label-bold text-label-bold text-tertiary">{{ $product->whatsapp_clicks_count }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layouts.admin>
