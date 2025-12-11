<div class="space-y-6">
    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $editingId ? __('Edit Produk') : __('Tambah Produk') }}</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Tonjolkan program dan paket solusi ekspor yang Anda tawarkan.') }}</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <flux:button wire:click="resetForm" variant="ghost" icon="x-mark" class="w-full sm:w-auto">{{ __('Reset') }}</flux:button>
                <div
                    x-data="{
                        open: false,
                        message: '{{ __('Tindakan berhasil.') }}',
                        show(detail) {
                            this.message = detail ?? '{{ __('Tindakan berhasil.') }}';
                            this.open = true;
                            setTimeout(() => (this.open = false), 4000);
                        }
                    }"
                    x-on:toast.window="show($event.detail?.message)"
                    x-show="open"
                    x-cloak
                    x-transition
                    class="w-full"
                >
                    <flux:toast icon="circle-check">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300" x-text="message"></span>
                    </flux:toast>
                </div>
            </div>
        </div>

        <div class="mt-6 space-y-6">
            <flux:field>
                <flux:label>{{ __('Judul Produk / Program') }}</flux:label>
                <flux:input wire:model.defer="title" placeholder="{{ __('Export Starter Program') }}" />
                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Deskripsi Nilai') }}</flux:label>
                <flux:textarea wire:model.defer="description" rows="6" placeholder="{{ __('Paket pendampingan 3 bulan untuk UMKM yang baru mulai ekspor...') }}" />
                <flux:error name="description" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Thumbnail Produk') }}</flux:label>
                <input
                    type="file"
                    wire:model="thumbnailUpload"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-zinc-900 file:me-4 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700"
                />
                <flux:error name="thumbnailUpload" />

                <div class="mt-3 flex items-center gap-4">
                    @if ($thumbnailUpload)
                        <div class="relative h-20 w-20 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <img src="{{ $thumbnailUpload->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover" />
                        </div>
                    @elseif ($thumbnailPath)
                        <div class="relative h-20 w-20 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <img src="{{ asset($thumbnailPath) }}" alt="Thumbnail" class="h-full w-full object-cover" />
                        </div>
                    @endif

                    @if ($thumbnailPath)
                        <button
                            type="button"
                            wire:click="$set('thumbnailPath', null)"
                            class="text-xs font-medium text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200"
                        >
                            {{ __('Hapus thumbnail saat ini') }}
                        </button>
                    @endif
                </div>
            </flux:field>
        </div>

        <div class="mt-6 flex flex-col gap-4 border-t border-zinc-100 pt-6 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Pastikan detail produk sudah lengkap sebelum menyimpan.') }}
            </p>
            <flux:button wire:click="save" icon="check" variant="primary" class="w-full sm:w-auto">
                {{ $editingId ? __('Simpan Perubahan') : __('Tambah Produk') }}
            </flux:button>
        </div>
    </flux:card>

    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Daftar Produk') }}</h2>
            <flux:badge variant="outline">{{ $products->total() }} {{ __('item') }}</flux:badge>
        </div>

        <div class="mt-4 grid gap-4">
            @forelse ($products as $product)
                <flux:panel class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div class="flex flex-1 gap-4">
                        <div class="relative h-20 w-20 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                            @if ($product->thumbnail_path)
                                <img src="{{ asset($product->thumbnail_path) }}" alt="{{ $product->title }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-zinc-500 dark:text-zinc-400">{{ __('No Image') }}</div>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $product->title }}</p>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400 line-clamp-3">{{ $product->description }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <flux:button size="xs" variant="outline" icon="pencil-square" wire:click="edit({{ $product->id }})">{{ __('Edit') }}</flux:button>
                        <flux:button size="xs" variant="outline" class="border-red-500 text-red-600 hover:bg-red-50 dark:border-red-500/70 dark:text-red-300 dark:hover:bg-red-500/10" icon="trash" wire:click="$set('confirmingDeletionId', {{ $product->id }})">{{ __('Hapus') }}</flux:button>
                    </div>
                </flux:panel>
            @empty
                <p class="py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">{{ __('Belum ada produk.') }}</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </flux:card>

    <flux:modal wire:model="confirmingDeletionId">
        <flux:card class="bg-white/95 backdrop-blur-sm dark:bg-zinc-900/90">
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Hapus Produk?') }}</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Langkah ini akan menghapus produk dari daftar secara permanen.') }}</p>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$set('confirmingDeletionId', null)">{{ __('Batal') }}</flux:button>
                <flux:button
                    variant="outline"
                    class="border-red-500 text-red-600 hover:bg-red-50 dark:border-red-500/70 dark:text-red-300 dark:hover:bg-red-500/10"
                    icon="trash"
                    wire:click="delete({{ $confirmingDeletionId ?? 0 }})"
                >{{ __('Hapus') }}</flux:button>
            </div>
        </flux:card>
    </flux:modal>

</div>
