@props([
    'siteName' => config('app.name'),
    'logoUrl' => asset('images/logo.png'),
    'settings' => collect(),
])

<header x-data="{ mobileOpen: false }"
    class="fixed inset-x-0 top-0 z-40 border-b border-neutral-200/60 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/70 dark:border-neutral-800 dark:bg-neutral-950/80">

    <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        
        {{-- LOGO --}}
        <a href="/" class="flex items-center gap-3">
            <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="h-12 w-auto object-contain" />

            <div class="flex flex-col">
                @if($settings['company_tagline'] ?? false)
                    <span class="text-xs text-neutral-500">{{ $settings['company_tagline'] }}</span>
                @endif
            </div>
        </a>

        {{-- NAV MENU DESKTOP --}}
        <nav class="hidden items-center gap-1 text-sm font-medium text-neutral-700 dark:text-neutral-200 lg:flex lg:ml-12">
            @php
                $navLinks = [
                    'Beranda'   => '#hero',
                    'Tentang'   => '#about',
                    'Layanan'   => '#services',
                    'Produk'    => '#products',
                    'Keunggulan'=> '#advantages',
                    'Testimoni' => '#testimonials',
                    'Galeri'    => '#gallery',
                    'Partner'   => '#partners',
                    'Lokasi'    => '#location',
                    'FAQ'       => '#faq',
                ];
            @endphp

            @foreach ($navLinks as $label => $hash)
                <a
                    href="{{ route('home').$hash }}"
                    class="group relative inline-flex items-center gap-1 rounded-lg px-3 py-2 text-current transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400"
                >
                    {{ $label }}
                    <span class="pointer-events-none absolute inset-x-3 -bottom-0.5 h-px scale-x-0 bg-current opacity-0 transition duration-300 group-hover:scale-x-100 group-hover:opacity-100"></span>
                </a>
            @endforeach
        </nav>

        {{-- HAMBURGER MENU --}}
        <button type="button" @click="mobileOpen = !mobileOpen"
            class="rounded-lg border border-neutral-200 p-2 text-neutral-600 transition hover:bg-neutral-100 dark:border-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-800 lg:hidden ml-auto">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- MOBILE MENU --}}
    <div x-show="mobileOpen" x-transition
        class="border-t border-neutral-200/60 bg-white/95 dark:border-neutral-800 dark:bg-neutral-950/80 lg:hidden">
        <div class="space-y-0.5 px-4 py-3 text-sm font-semibold text-neutral-700 dark:text-neutral-200">

            @foreach ($navLinks as $label => $hash)
                <a href="{{ route('home').$hash }}" @click="mobileOpen = false"
                    class="block rounded-lg px-3 py-2 transition hover:bg-neutral-100 hover:text-emerald-600 dark:hover:bg-neutral-800 dark:hover:text-emerald-400">
                    {{ $label }}
                </a>
            @endforeach

        </div>
    </div>
</header>
