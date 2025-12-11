<div {{ $attributes->class('fixed inset-x-0 bottom-4 z-50 flex justify-center px-4 pointer-events-none') }}>
    <div class="pointer-events-auto inline-flex max-w-md items-center gap-3 rounded-xl border border-zinc-200 bg-white/95 px-4 py-3 text-sm shadow-lg dark:border-zinc-700 dark:bg-zinc-900/95">
        {{ $slot }}
    </div>
</div>
