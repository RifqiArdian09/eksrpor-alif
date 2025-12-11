<div class="space-y-6">
    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $editingId ? __('Edit Partner') : __('Tambah Partner') }}</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Kelola jaringan partner strategis untuk memperkuat kredibilitas brand.') }}</p>
            </div>
            <div class="flex flex-col items-end gap-2 w-full sm:w-auto">
                <flux:button wire:click="resetForm" variant="ghost" icon="x-mark" class="w-full sm:w-auto">{{ __('Reset') }}</flux:button>
                <div
                    x-data="{
                        open: false,
                        message: '{{ __('Perubahan berhasil disimpan.') }}',
                        show(detail) {
                            this.message = detail ?? '{{ __('Perubahan berhasil disimpan.') }}';
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
                <flux:label>{{ __('Nama Partner') }}</flux:label>
                <flux:input wire:model.defer="name" placeholder="{{ __('Garuda Logistics') }}" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Logo Partner') }}</flux:label>
                <input
                    type="file"
                    wire:model="logoUpload"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-zinc-900 file:me-4 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700"
                />
                <flux:error name="logoUpload" />

                <div class="mt-3 flex items-center gap-4">
                    @if ($logoUpload)
                        <div class="relative h-16 w-24 overflow-hidden rounded-lg border border-zinc-200 bg-white p-2 dark:border-zinc-700 dark:bg-zinc-900">
                            <img src="{{ $logoUpload->temporaryUrl() }}" alt="Logo preview" class="h-full w-full object-contain" />
                        </div>
                    @elseif ($logoPath)
                        <div class="relative h-16 w-24 overflow-hidden rounded-lg border border-zinc-200 bg-white p-2 dark:border-zinc-700 dark:bg-zinc-900">
                            <img src="{{ asset($logoPath) }}" alt="Logo" class="h-full w-full object-contain" />
                        </div>
                    @endif

                    @if ($logoPath)
                        <button
                            type="button"
                            wire:click="$set('logoPath', null)"
                            class="text-xs font-medium text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200"
                        >
                            {{ __('Hapus logo saat ini') }}
                        </button>
                    @endif
                </div>

                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Gunakan SVG/PNG berlatar transparan untuk hasil terbaik.') }}</p>
            </flux:field>
        </div>

        <div class="mt-6 flex flex-col gap-4 border-t border-zinc-100 pt-6 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Pastikan logo dan nama partner sudah benar sebelum menyimpan.') }}
            </p>
            <flux:button wire:click="save" icon="check" variant="primary" class="w-full sm:w-auto">
                {{ $editingId ? __('Simpan Perubahan') : __('Tambah Partner') }}
            </flux:button>
        </div>
    </flux:card>

    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Daftar Partner') }}</h2>
            <flux:badge variant="outline">{{ $partners->total() }} {{ __('item') }}</flux:badge>
        </div>

        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @forelse ($partners as $partner)
                <flux:panel class="flex flex-col items-center gap-3 text-center">
                    <div class="relative h-16 w-24 overflow-hidden rounded-lg border border-zinc-200 bg-white p-2 dark:border-zinc-700 dark:bg-zinc-900">
                        @if ($partner->logo_path)
                            <img src="{{ asset($partner->logo_path) }}" alt="{{ $partner->name }}" class="h-full w-full object-contain" />
                        @else
                            <div class="flex h-full w-full items-center justify-center text-xs text-zinc-500 dark:text-zinc-400">{{ __('No Logo') }}</div>
                        @endif
                    </div>
                    <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $partner->name }}</p>
                    <div class="flex gap-2">
                        <flux:button size="xs" variant="outline" icon="pencil-square" wire:click="edit({{ $partner->id }})">{{ __('Edit') }}</flux:button>
                        <flux:button size="xs" variant="outline" class="border-red-500 text-red-600 hover:bg-red-50 dark:border-red-500/70 dark:text-red-300 dark:hover:bg-red-500/10" icon="trash" wire:click="$set('confirmingDeletionId', {{ $partner->id }})">{{ __('Hapus') }}</flux:button>
                    </div>
                </flux:panel>
            @empty
                <p class="py-8 text-center text-sm text-zinc-500 dark:text-zinc-400 md:col-span-2">{{ __('Belum ada partner.') }}</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $partners->links() }}
        </div>
    </flux:card>

    <flux:modal wire:model="confirmingDeletionId">
        <flux:card class="bg-white/95 backdrop-blur-sm dark:bg-zinc-900/90">
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Hapus Partner?') }}</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Pastikan branding yang tampil di website selalu relevan.') }}</p>
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
