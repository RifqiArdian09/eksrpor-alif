<div class="space-y-6">
    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $editingId ? __('Edit Dokumentasi') : __('Tambah Dokumentasi') }}</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Bagikan cerita kegiatan bisnis matching, pengiriman, atau aktivitas komunitas eksportir.') }}</p>
            </div>
            <div class="flex flex-col gap-2 w-full sm:w-auto">
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

        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <flux:field class="md:col-span-2">
                <flux:label>{{ __('Judul Dokumentasi') }}</flux:label>
                <flux:input wire:model.defer="title" placeholder="{{ __('Business Matching Singapura') }}" />
                <flux:error name="title" />
            </flux:field>

            <flux:field class="md:col-span-2">
                <flux:label>{{ __('Deskripsi') }}</flux:label>
                <flux:textarea wire:model.defer="description" rows="6" placeholder="{{ __('Mempertemukan 25 UMKM dengan buyer ritel premium di Singapura...') }}" />
                <flux:error name="description" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Tanggal Aktivitas') }}</flux:label>
                <flux:input type="date" wire:model.defer="activityDate" />
                <flux:error name="activityDate" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Cover Image') }}</flux:label>
                <input
                    type="file"
                    wire:model="coverUpload"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-zinc-900 file:me-4 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700"
                />
                <flux:error name="coverUpload" />

                <div class="mt-3 flex items-center gap-4">
                    @if ($coverUpload)
                        <div class="relative h-24 w-40 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <img src="{{ $coverUpload->temporaryUrl() }}" alt="Cover preview" class="h-full w-full object-cover" />
                        </div>
                    @elseif ($imagePath)
                        <div class="relative h-24 w-40 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <img src="{{ asset($imagePath) }}" alt="Cover" class="h-full w-full object-cover" />
                        </div>
                    @endif

                    @if ($imagePath)
                        <button
                            type="button"
                            wire:click="$set('imagePath', null)"
                            class="text-xs font-medium text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200"
                        >
                            {{ __('Hapus cover saat ini') }}
                        </button>
                    @endif
                </div>
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Slug URL') }}</flux:label>
                <flux:input wire:model.defer="slug" placeholder="business-matching-singapura" />
                <flux:error name="slug" />
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Slug unik dibutuhkan untuk detail halaman dokumentasi.') }}</p>
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Upload Gambar Tambahan') }}</flux:label>
                <input
                    type="file"
                    wire:model="imagesUploads"
                    accept="image/*"
                    multiple
                    class="mt-1 block w-full text-sm text-zinc-900 file:me-4 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700"
                />
                <flux:error name="imagesUploads" />

                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($imagesUploads as $upload)
                        <div class="relative h-14 w-20 overflow-hidden rounded-md border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <img src="{{ $upload->temporaryUrl() }}" alt="Additional image" class="h-full w-full object-cover" />
                        </div>
                    @endforeach
                </div>
            </flux:field>
        </div>

        <div class="mt-6 flex flex-col gap-4 border-t border-zinc-100 pt-6 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Pastikan detail tanggal, slug, dan visual sudah lengkap sebelum publikasi.') }}
            </p>
            <flux:button wire:click="save" icon="check" variant="primary" class="w-full sm:w-auto">
                {{ $editingId ? __('Simpan Perubahan') : __('Publikasikan Dokumentasi') }}
            </flux:button>
        </div>
    </flux:card>

    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Riwayat Dokumentasi') }}</h2>
            <flux:badge variant="outline">{{ $items->total() }} {{ __('kegiatan') }}</flux:badge>
        </div>

        <div class="mt-4 space-y-4">
            @forelse ($items as $item)
                <flux:panel class="space-y-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:gap-4">
                        <div class="relative h-24 w-full overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 md:h-24 md:w-32 dark:border-zinc-800 dark:bg-zinc-800/70">
                            @if ($item->image_path)
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-zinc-500 dark:text-zinc-400">{{ __('No Image') }}</div>
                            @endif
                        </div>
                        <div class="flex-1 space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600 dark:text-emerald-300">{{ optional($item->activity_date)->translatedFormat('d M Y') }}</p>
                            </div>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $item->title }}</p>
                           
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <flux:button size="xs" variant="outline" icon="pencil-square" wire:click="edit({{ $item->id }})">{{ __('Edit') }}</flux:button>
                        <flux:button size="xs" variant="outline" class="border-red-500 text-red-600 hover:bg-red-50 dark:border-red-500/70 dark:text-red-300 dark:hover:bg-red-500/10" icon="trash" wire:click="$set('confirmingDeletionId', {{ $item->id }})">{{ __('Hapus') }}</flux:button>
                    </div>
                </flux:panel>
            @empty
                <p class="py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">{{ __('Belum ada dokumentasi kegiatan.') }}</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </flux:card>

    <flux:modal wire:model="confirmingDeletionId">
        <flux:card class="bg-white/95 backdrop-blur-sm dark:bg-zinc-900/90">
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Hapus Dokumentasi?') }}</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Pastikan dokumentasi sudah dicadangkan sebelum menghapus.') }}</p>
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
