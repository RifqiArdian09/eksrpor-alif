<div class="space-y-8">
    <flux:header>
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Hero Section') }}</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Perkuat pesan utama dan visual hero banner landing page.') }}</p>
            <div
                x-data="{
                    open: false,
                    message: '{{ __('Hero section berhasil diperbarui.') }}',
                    show(detail) {
                        this.message = detail ?? '{{ __('Hero section berhasil diperbarui.') }}';
                        this.open = true;
                        setTimeout(() => (this.open = false), 4000);
                    }
                }"
                x-on:saved.window="show($event.detail?.message)"
                x-show="open"
                x-cloak
                x-transition
            >
                <flux:toast icon="circle-check">
                    <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Perubahan disimpan!') }}</span>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400" x-text="message"></span>
                </flux:toast>
            </div>
        </div>
    </flux:header>

    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <flux:field>
            <flux:label>{{ __('Tagline') }}</flux:label>
            <flux:input wire:model.defer="tagline" placeholder="{{ __('One Stop Export Solution') }}" />
            <flux:error name="tagline" />
        </flux:field>

        <flux:field class="mt-6">
            <flux:label>{{ __('Judul Utama') }}</flux:label>
            <flux:input wire:model.defer="title" placeholder="{{ __('Membuka Peluang Ekspor Tanpa Ribet') }}" />
            <flux:error name="title" />
        </flux:field>

        <flux:field class="mt-6">
            <flux:label>{{ __('Deskripsi Ringkas') }}</flux:label>
            <flux:textarea wire:model.defer="description" rows="4" placeholder="{{ __('Kami bantu urus lisensi, dokumen, shipping...') }}" />
            <flux:error name="description" />
        </flux:field>

        <flux:field class="mt-6">
            <flux:label>{{ __('Media Hero (Gambar / Video)') }}</flux:label>
            <input
                type="file"
                wire:model="mediaUpload"
                accept="image/*,video/*"
                class="mt-1 block w-full text-sm text-zinc-900 file:me-4 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700"
            />
            <flux:error name="mediaUpload" />

            <div class="mt-3 flex items-center gap-4">
                @if ($mediaUpload)
                    @php
                        $mime = method_exists($mediaUpload, 'getMimeType') ? ($mediaUpload->getMimeType() ?? '') : '';
                        $isImage = str($mime)->startsWith('image/');
                    @endphp

                    @if ($isImage)
                        <div class="relative h-24 w-40 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <img src="{{ $mediaUpload->temporaryUrl() }}" alt="Hero preview" class="h-full w-full object-cover" />
                        </div>
                    @else
                        <div class="rounded-lg border border-dashed border-zinc-300 px-3 py-2 text-xs text-zinc-600 dark:border-zinc-700 dark:text-zinc-300">
                            {{ __('File terpilih:') }} {{ $mediaUpload->getClientOriginalName() }}
                        </div>
                    @endif
                @elseif ($mediaPath)
                    <div class="flex flex-col gap-1 text-xs text-zinc-600 dark:text-zinc-300">
                        <span class="font-medium">{{ __('Media saat ini:') }}</span>
                        <span class="font-mono break-all">{{ $mediaPath }}</span>
                    </div>
                @endif

                @if ($mediaPath)
                    <button
                        type="button"
                        wire:click="$set('mediaPath', null)"
                        class="text-xs font-medium text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200"
                    >
                        {{ __('Hapus media saat ini') }}
                    </button>
                @endif
            </div>

            <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                {{ __('Untuk hasil terbaik, gunakan gambar rasio 16:9 atau video berdurasi pendek. File upload akan disimpan ke storage publik.') }}
            </p>
        </flux:field>

        <div class="mt-8 flex flex-col gap-4 border-t border-zinc-100 pt-6 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Pastikan teks dan media sudah sesuai sebelum menyimpan perubahan.') }}
            </p>
            <flux:button wire:click="save" icon="check" variant="primary" class="w-full sm:w-auto">
                {{ __('Simpan') }}
            </flux:button>
        </div>
    </flux:card>
</div>
