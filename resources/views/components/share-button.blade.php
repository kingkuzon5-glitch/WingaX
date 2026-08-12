@props(['url', 'title', 'class' => 'w-12 h-12 bg-surface/60 backdrop-blur-md rounded-full flex items-center justify-center shadow-sm'])

<button type="button" data-share data-share-url="{{ $url }}" data-share-title="{{ $title }}"
        {{ $attributes->merge(['class' => $class]) }}>
    <span class="material-symbols-outlined text-on-surface">share</span>
</button>
