@props(['label', 'value', 'icon', 'change' => null])

<div class="bg-surface-container-lowest rounded-lg p-md shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low">
    <div class="flex items-center justify-between mb-sm">
        <div class="w-10 h-10 rounded-full bg-primary-container/10 text-primary flex items-center justify-center">
            <span class="material-symbols-outlined">{{ $icon }}</span>
        </div>
        @if (! is_null($change))
            <span class="font-label-bold text-label-bold {{ $change >= 0 ? 'text-tertiary' : 'text-error' }} flex items-center gap-0.5">
                <span class="material-symbols-outlined text-[14px]">{{ $change >= 0 ? 'trending_up' : 'trending_down' }}</span>
                {{ $change >= 0 ? '+' : '' }}{{ $change }}%
            </span>
        @endif
    </div>
    <div class="font-headline-lg-mobile text-headline-lg-mobile text-on-background">{{ $value }}</div>
    <div class="font-body-sm text-body-sm text-on-surface-variant mt-1">{{ $label }}</div>
</div>
