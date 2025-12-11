@props([
    'icon' => null,
    'heading' => null,
])

<div {{ $attributes->class('rounded-xl border border-dashed border-zinc-200/80 bg-white/80 p-4 dark:border-zinc-700/80 dark:bg-zinc-900/60') }}>
    @if ($heading || $icon)
        <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-zinc-800 dark:text-zinc-100">
            @if ($icon)
                <x-flux.icon :name="$icon" class="h-4 w-4" />
            @endif
            {{ $heading }}
        </div>
    @endif

    {{ $slot }}
</div>
