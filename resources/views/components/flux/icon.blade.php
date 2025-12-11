@props([
    'name' => null,
])

@php
    $classes = 'h-4 w-4 text-zinc-500 dark:text-zinc-300';
@endphp

<svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'aria-hidden' => 'true']) }} xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5">
    <circle cx="12" cy="12" r="9" class="opacity-30" />
    <path d="M12 8v4l2.5 2.5" stroke-linecap="round" stroke-linejoin="round" />
</svg>
