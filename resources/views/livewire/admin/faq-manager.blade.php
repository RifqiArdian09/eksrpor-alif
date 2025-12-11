<div class="space-y-6">
    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $editingId ? __('Edit FAQ') : __('Tambah FAQ') }}</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Jawab pertanyaan yang paling sering muncul dari calon buyer dan partner.') }}</p>
            </div>
            <div class="flex flex-col items-end gap-2 w-full sm:w-auto">
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
                <flux:label>{{ __('Pertanyaan') }}</flux:label>
                <flux:input wire:model.defer="question" placeholder="{{ __('Produk apa yang bisa diekspor?') }}" />
                <flux:error name="question" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Jawaban') }}</flux:label>
                <flux:textarea wire:model.defer="answer" rows="6" placeholder="{{ __('Kami fokus pada produk FMCG, agrikultur olahan, fesyen, dan kerajinan...') }}" />
                <flux:error name="answer" />
            </flux:field>
        </div>

        <div class="mt-6 flex flex-col gap-4 border-t border-zinc-100 pt-6 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Tulis jawaban singkat dan padat agar mudah dipahami pengunjung.') }}
            </p>
            <flux:button wire:click="save" icon="check" variant="primary" class="w-full sm:w-auto">
                {{ $editingId ? __('Simpan Perubahan') : __('Tambah FAQ') }}
            </flux:button>
        </div>
    </flux:card>

    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Daftar FAQ') }}</h2>
            <flux:badge variant="outline">{{ $faqs->total() }} {{ __('item') }}</flux:badge>
        </div>

        <div class="mt-4 divide-y divide-zinc-200/70 dark:divide-zinc-800">
            @forelse ($faqs as $faq)
                <div class="flex items-start justify-between gap-4 py-4">
                    <div>
                        <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $faq->question }}</p>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $faq->answer }}</p>
                    </div>
                    <div class="flex gap-2">
                        <flux:button size="xs" variant="outline" icon="pencil-square" wire:click="edit({{ $faq->id }})">{{ __('Edit') }}</flux:button>
                        <flux:button size="xs" variant="outline" class="border-red-500 text-red-600 hover:bg-red-50 dark:border-red-500/70 dark:text-red-300 dark:hover:bg-red-500/10" icon="trash" wire:click="$set('confirmingDeletionId', {{ $faq->id }})">{{ __('Hapus') }}</flux:button>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">{{ __('Belum ada FAQ.') }}</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $faqs->links() }}
        </div>
    </flux:card>

    <flux:modal wire:model="confirmingDeletionId">
        <flux:card class="bg-white/95 backdrop-blur-sm dark:bg-zinc-900/90">
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Hapus FAQ?') }}</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Pastikan informasi alternatif telah tersedia sebelum menghapus jawaban.') }}</p>
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
