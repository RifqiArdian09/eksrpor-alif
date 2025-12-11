<div class="space-y-6">
    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $editingId ? __('Edit Service') : __('Tambah Service') }}</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Detailkan layanan end-to-end yang Anda tawarkan kepada eksportir.') }}</p>
            </div>
            <flux:button wire:click="resetForm" variant="ghost" icon="x-mark">{{ __('Reset') }}</flux:button>
        </div>

        <div class="mt-6 space-y-6">
            <div class="space-y-2">
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ __('Judul Layanan') }}</label>
                <flux:input wire:model.defer="title" placeholder="{{ __('Manajemen Dokumen & Legalitas') }}" />
                <flux:error name="title" />
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ __('Deskripsi Detail') }}</label>
                <flux:textarea wire:model.defer="description" rows="6" placeholder="{{ __('Pengurusan perizinan BPOM, Halal, COO, hingga sertifikasi negara tujuan.') }}" />
                <flux:error name="description" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <flux:button wire:click="save" icon="check" variant="primary">{{ $editingId ? __('Simpan Perubahan') : __('Tambah Layanan') }}</flux:button>
        </div>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Daftar Layanan') }}</h2>
            <span class="inline-flex items-center gap-1 rounded-full border border-zinc-200 px-3 py-1 text-xs font-medium uppercase tracking-wide text-zinc-600 dark:border-zinc-700 dark:text-zinc-300">{{ $services->total() }} {{ __('item') }}</span>
        </div>

        <div class="mt-4 divide-y divide-zinc-200/70 dark:divide-zinc-800">
            @forelse ($services as $service)
                <div class="flex items-start justify-between gap-4 py-4">
                    <div>
                        <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $service->title }}</p>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $service->description }}</p>
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-500">{{ __('Ikon otomatis:') }} <span class="font-mono">{{ $service->icon }}</span></p>
                    </div>
                    <div class="space-y-6">
                        <flux:button size="xs" variant="outline" icon="pencil-square" wire:click="edit({{ $service->id }})">{{ __('Edit') }}</flux:button>
                        <flux:button
                            size="xs"
                            variant="outline"
                            class="border-red-500 text-red-600 hover:bg-red-50 dark:border-red-500/70 dark:text-red-300 dark:hover:bg-red-500/10"
                            icon="trash"
                            wire:click="delete({{ $service->id }})"
                            onclick="if(!confirm('{{ __('Hapus layanan ini?') }}')) { event.preventDefault(); event.stopPropagation(); }"
                        >{{ __('Hapus') }}</flux:button>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">{{ __('Belum ada layanan.') }}</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $services->links() }}
        </div>
    </div>
</div>
