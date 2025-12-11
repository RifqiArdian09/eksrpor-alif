<div class="space-y-8">
    <flux:header>
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('About Section') }}</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Kelola visi, misi, dan cerita perusahaan yang ditampilkan kepada calon partner.') }}</p>
        </div>
        <div
            x-data="{
                open: false,
                message: '{{ __('About section berhasil diperbarui.') }}',
                show(detail) {
                    this.message = detail ?? '{{ __('About section berhasil diperbarui.') }}';
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
    </flux:header>

    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <flux:field>
            <flux:label>{{ __('Visi Perusahaan') }}</flux:label>
            <flux:input wire:model.defer="vision" placeholder="{{ __('Menjadi mitra ekspor terpercaya...') }}" />
            <flux:error name="vision" />
        </flux:field>

        <flux:field class="mt-6">
            <flux:label>{{ __('Misi Perusahaan') }}</flux:label>
            <flux:textarea wire:model.defer="mission" rows="3" placeholder="{{ __('Mendampingi pelaku usaha lokal...') }}" />
            <flux:error name="mission" />
        </flux:field>

        <flux:field class="mt-6">
            <div class="flex items-center justify-between">
                <flux:label>{{ __('Konten Narasi') }}</flux:label>
                <div class="flex gap-2">
                    <flux:button size="xs" variant="ghost" icon="plus" wire:click="markdownSnippet('values')">{{ __('Tambahkan Nilai') }}</flux:button>
                    <flux:button size="xs" variant="ghost" icon="plus" wire:click="markdownSnippet('cta')">{{ __('Tambahkan CTA') }}</flux:button>
                    <div class="inline-flex items-center gap-1 rounded-full border border-zinc-200 bg-zinc-100 p-0.5 text-xs dark:border-zinc-700 dark:bg-zinc-800">
                        <button
                            type="button"
                            wire:click="$set('previewMode', 'markdown')"
                            class="rounded-full px-3 py-1 {{ $previewMode === 'markdown' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-50' : 'text-zinc-500 dark:text-zinc-400' }}"
                        >
                            Markdown
                        </button>
                        <button
                            type="button"
                            wire:click="$set('previewMode', 'preview')"
                            class="rounded-full px-3 py-1 {{ $previewMode === 'preview' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-50' : 'text-zinc-500 dark:text-zinc-400' }}"
                        >
                            Preview
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-3 grid gap-4 md:grid-cols-2">
                <flux:textarea wire:model.defer="content" rows="12" class="font-mono text-sm" placeholder="# {{ __('Ceritakan perjalanan perusahaan...') }}" />
                <div class="prose max-w-none rounded-lg border border-dashed border-zinc-200 bg-zinc-50/60 p-4 dark:border-zinc-700 dark:bg-zinc-800/50">
                    @if ($previewMode === 'preview')
                        {!! str($content)->markdown() !!}
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Aktifkan mode preview untuk melihat hasil render Markdown.') }}</p>
                    @endif
                </div>
            </div>
            <flux:error name="content" />
        </flux:field>

        <flux:field class="mt-6">
            <flux:label>{{ __('Gambar Pendukung') }}</flux:label>
            <input
                type="file"
                wire:model="imageUpload"
                accept="image/*"
                class="mt-1 block w-full text-sm text-zinc-900 file:me-4 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700"
            />
            <flux:error name="imageUpload" />

            <div class="mt-3 flex items-center gap-4">
                @if ($imageUpload)
                    <div class="relative h-20 w-32 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                        <img src="{{ $imageUpload->temporaryUrl() }}" alt="About preview" class="h-full w-full object-cover" />
                    </div>
                @elseif ($imagePath)
                    <div class="relative h-20 w-32 overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800/70">
                        <img src="{{ asset($imagePath) }}" alt="About image" class="h-full w-full object-cover" />
                    </div>
                @endif

                @if ($imagePath)
                    <button
                        type="button"
                        wire:click="$set('imagePath', null)"
                        class="text-xs font-medium text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200"
                    >
                        {{ __('Hapus gambar saat ini') }}
                    </button>
                @endif
            </div>

            <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Gunakan visual resolusi tinggi dengan rasio mendukung layout landing page.') }}</p>
        </flux:field>
        <div class="mt-8 flex flex-col gap-4 border-t border-zinc-100 pt-6 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Review kembali isi visi, misi, dan narasi sebelum menyimpan.') }}
            </p>
            <flux:button wire:click="save" icon="check" variant="primary" class="w-full sm:w-auto">
                {{ __('Simpan Perubahan') }}
            </flux:button>
        </div>
    </flux:card>
</div>
