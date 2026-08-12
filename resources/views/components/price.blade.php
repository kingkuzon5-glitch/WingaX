@props(['price', 'discountPrice' => null, 'size' => 'md'])

@php
    $hasDiscount = ! is_null($discountPrice) && bccomp((string) $discountPrice, (string) $price, 2) < 0;
    $sizeClasses = match ($size) {
        'lg' => 'font-headline-lg-mobile text-headline-lg-mobile',
        'sm' => 'font-body-sm text-body-sm font-bold',
        default => 'font-title-md text-title-md',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 flex-wrap']) }}>
    <span class="{{ $sizeClasses }} text-primary">TZS {{ number_format((float) ($hasDiscount ? $discountPrice : $price)) }}</span>
    @if ($hasDiscount)
        <span class="font-body-sm text-body-sm text-secondary line-through">TZS {{ number_format((float) $price) }}</span>
    @endif
</span>
