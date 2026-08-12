@foreach ($products as $product)
    <x-feed-item :product="$product" />
@endforeach

@if ($products->hasMorePages())
    <div id="feed-sentinel" data-cursor="{{ $products->nextCursor()?->encode() }}"></div>
@endif
