@props(['href', 'icon', 'active' => false])

<li>
    <a href="{{ $href }}"
       class="flex items-center gap-4 px-md py-3 rounded-r-full transition-colors active:translate-x-1
              {{ $active ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
        <span class="material-symbols-outlined {{ $active ? 'filled' : '' }}">{{ $icon }}</span>
        <span class="font-body-lg text-body-lg">{{ $slot }}</span>
    </a>
</li>
