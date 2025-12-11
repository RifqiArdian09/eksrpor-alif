<div class="space-y-8">
    <flux:header>
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Kontak & Media Sosial') }}</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Perbarui informasi kontak utama dan kanal sosial agar calon partner mudah menghubungi Anda.') }}</p>
        </div>
        <div
            x-data="{
                open: false,
                message: '{{ __('Pengaturan berhasil disimpan.') }}',
                show(detail) {
                    this.message = detail ?? '{{ __('Pengaturan berhasil disimpan.') }}';
                    this.open = true;
                    setTimeout(() => (this.open = false), 4000);
                }
            }"
            x-on:toast.window="show($event.detail?.message)"
            x-show="open"
            x-cloak
            x-transition
        >
            <flux:toast icon="circle-check">
                <span class="text-sm text-zinc-700 dark:text-zinc-300" x-text="message"></span>
            </flux:toast>
        </div>
    </flux:header>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_1fr]">
        <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Informasi Kontak') }}</h2>

            <div class="mt-6 space-y-6">
                <flux:field>
                    <flux:label>{{ __('Nama Perusahaan') }}</flux:label>
                    <flux:input wire:model.defer="companyName" placeholder="Ekspor Hub Nusantara" />
                    <flux:error name="companyName" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Nomor Telepon') }}</flux:label>
                    <flux:input wire:model.defer="phone" placeholder="+62 812-3456-7890" />
                    <flux:error name="phone" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Email Utama') }}</flux:label>
                    <flux:input wire:model.defer="email" placeholder="hello@eksporhub.id" />
                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Alamat Kantor') }}</flux:label>
                    <flux:textarea rows="3" wire:model.defer="address" placeholder="Jl. Pelabuhan No. 18, Penjaringan, Jakarta Utara 14440" />
                    <flux:error name="address" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Jam Operasional') }}</flux:label>
                    <flux:input wire:model.defer="officeHours" placeholder="Senin - Jumat, 09.00 - 18.00 WIB" />
                    <flux:error name="officeHours" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Logo Perusahaan') }}</flux:label>
                    <input
                        type="file"
                        wire:model="logoUpload"
                        accept="image/*"
                        class="mt-1 block w-full text-sm text-zinc-900 file:me-4 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 dark:hover:file:bg-zinc-700"
                    />
                    <flux:error name="logoUpload" />

                    <div class="mt-3 flex items-center gap-4">
                        @if ($logoUpload)
                            <div class="relative h-12 w-32 overflow-hidden rounded-lg border border-zinc-200 bg-white p-2 dark:border-zinc-700 dark:bg-zinc-900">
                                <img src="{{ $logoUpload->temporaryUrl() }}" alt="Logo preview" class="h-full w-full object-contain" />
                            </div>
                        @elseif ($logo)
                            <div class="relative h-12 w-32 overflow-hidden rounded-lg border border-zinc-200 bg-white p-2 dark:border-zinc-700 dark:bg-zinc-900">
                                <img src="{{ asset($logo) }}" alt="Logo" class="h-full w-full object-contain" />
                            </div>
                        @endif

                        @if ($logo)
                            <button
                                type="button"
                                wire:click="$set('logo', null)"
                                class="text-xs font-medium text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200"
                            >
                                {{ __('Hapus logo') }}
                            </button>
                        @endif
                    </div>
                </flux:field>
            </div>
        </flux:card>

        <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Media Sosial') }}</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Gunakan URL penuh termasuk https:// untuk setiap platform.') }}</p>

            <div class="mt-6 space-y-6">
                <flux:field>
                    <flux:label>{{ __('Facebook') }}</flux:label>
                    <flux:input wire:model.defer="facebook" placeholder="https://facebook.com/eksporhub" />
                    <flux:error name="facebook" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Instagram') }}</flux:label>
                    <flux:input wire:model.defer="instagram" placeholder="https://instagram.com/eksporhub" />
                    <flux:error name="instagram" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('LinkedIn') }}</flux:label>
                    <flux:input wire:model.defer="linkedin" placeholder="https://linkedin.com/company/eksporhub" />
                    <flux:error name="linkedin" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('YouTube') }}</flux:label>
                    <flux:input wire:model.defer="youtube" placeholder="https://youtube.com/@eksporhub" />
                    <flux:error name="youtube" />
                </flux:field>
            </div>
        </flux:card>
    </div>

    <div class="flex flex-col gap-4 rounded-3xl border border-zinc-100 bg-white/80 p-6 text-sm text-zinc-600 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/70 dark:text-zinc-300">
        <p>{{ __('Pastikan semua informasi kontak dan tautan sosial aktif sebelum menyimpan perubahan.') }}</p>
        <flux:button wire:click="save" icon="check" variant="primary" class="w-full sm:w-auto self-start sm:self-end">
            {{ __('Simpan Pengaturan') }}
        </flux:button>
    </div>
</div>
