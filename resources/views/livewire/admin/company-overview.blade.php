<div class="space-y-8">
    <div class="grid gap-4 md:grid-cols-3">
        @foreach ($stats as $stat)
            <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
                <div class="flex items-center gap-4">
                    <flux:avatar size="lg" icon="{{ $stat['icon'] }}" class="bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300" />
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                        <p class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $stat['count'] }}</p>
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>

    <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Brand Voice & Elevator Pitch') }}</h2>
                <p class="mt-2 max-w-3xl text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                    {{ __('Pastikan hero section dan about section selalu mencerminkan positioning perusahaan terbaru. Update copy, visual, dan CTA secara berkala agar tetap relevan.') }}
                </p>
            </div>
            <div class="flex gap-3">
                <flux:button :href="route('admin.hero')" variant="outline" icon="sparkles" wire:navigate>{{ __('Edit Hero') }}</flux:button>
                <flux:button :href="route('admin.about')" icon="pencil-square" wire:navigate>{{ __('Edit About') }}</flux:button>
            </div>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <flux:panel icon="photo" heading="{{ __('Hero Terakhir Di-update') }}">
                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ optional($heroUpdatedAt)->diffForHumans() ?? __('Belum pernah diupdate') }}
                </div>
            </flux:panel>
            <flux:panel icon="document-text" heading="{{ __('Tentang Perusahaan') }}">
                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ optional($aboutUpdatedAt)->diffForHumans() ?? __('Belum pernah diupdate') }}
                </div>
            </flux:panel>
        </div>
    </flux:card>

    <div class="grid gap-6 lg:grid-cols-3">
        <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Aktivitas Terakhir') }}</h2>
                <flux:button :href="route('admin.gallery')" variant="ghost" icon="arrow-top-right-on-square" wire:navigate>{{ __('Kelola Galeri') }}</flux:button>
            </div>

            <div class="mt-4 space-y-4">
                @forelse ($recentActivity as $item)
                    <flux:panel class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ class_basename($item) }}</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ __('Terakhir diperbarui') }} {{ optional($item->updated_at)->diffForHumans() }}
                            </p>
                        </div>
                        <flux:badge variant="outline">{{ $item->updated_at?->format('d M Y') }}</flux:badge>
                    </flux:panel>
                @empty
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Belum ada aktivitas. Mulai tambahkan highlight, layanan, atau testimoni untuk mengisi profil perusahaan.') }}</p>
                @endforelse
            </div>
        </flux:card>

        <flux:card class="bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Kontak Utama') }}</h2>
            <dl class="mt-4 space-y-3 text-sm text-zinc-600 dark:text-zinc-400">
                <div class="flex items-start justify-between gap-4">
                    <dt class="flex items-center gap-2">
                        <flux:icon name="phone" class="h-4 w-4" />
                        {{ __('Telepon') }}
                    </dt>
                    <dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $contactSettings['company.phone'] ?? '—' }}</dd>
                </div>
                <div class="flex items-start justify-between gap-4">
                    <dt class="flex items-center gap-2">
                        <flux:icon name="envelope" class="h-4 w-4" />
                        {{ __('Email') }}
                    </dt>
                    <dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $contactSettings['company.email'] ?? '—' }}</dd>
                </div>
                <div class="flex items-start justify-between gap-4">
                    <dt class="flex items-center gap-2">
                        <flux:icon name="map-pin" class="h-4 w-4" />
                        {{ __('Alamat') }}
                    </dt>
                    <dd class="max-w-[16rem] text-right text-sm">{{ $contactSettings['company.address'] ?? '—' }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Social Links') }}</h3>
                <ul class="mt-3 space-y-2">
                    @foreach (data_get($contactSettings, 'company.socials', []) as $platform => $url)
                        <li class="flex items-center justify-between text-sm">
                            <span class="capitalize text-zinc-600 dark:text-zinc-400">{{ $platform }}</span>
                            <a href="{{ $url }}" class="font-medium text-blue-600 hover:underline dark:text-blue-400" target="_blank" rel="noopener">
                                {{ __('Buka') }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </flux:card>
    </div>
</div>
