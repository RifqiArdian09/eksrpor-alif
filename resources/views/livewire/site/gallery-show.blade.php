@once
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endpush
@endonce

<div class="bg-white">
    <section class="mx-auto max-w-5xl space-y-10 px-6 py-12 text-center">
        <div class="space-y-4">
            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-600">Dokumentasi</p>
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ $item->title }}</h1>
            
        </div>

        @if($item->image_path || $item->images)
            <div class="relative overflow-hidden rounded-3xl border border-gray-200 bg-gray-50 shadow-xl">
                <div class="swiper gallery-swiper">
                    <div class="swiper-wrapper">
                        @if($item->image_path)
                            <div class="swiper-slide">
                                <div class="flex h-[420px] items-center justify-center bg-white">
                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="max-h-full w-auto object-contain" loading="lazy">
                                </div>
                            </div>
                        @endif
                        @foreach($item->images ?? [] as $image)
                            <div class="swiper-slide">
                                <div class="flex h-[420px] items-center justify-center bg-white">
                                    <img src="{{ asset($image) }}" alt="{{ $item->title }}" class="max-h-full w-auto object-contain" loading="lazy">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/20"></div>
            </div>
        @endif

        <div class="flex flex-col items-center gap-3">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-700 transition hover:border-emerald-400 hover:text-emerald-600" wire:navigate>
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7"/>
                </svg>
                Kembali ke Galeri
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-4xl space-y-8 px-6 pb-12 text-center">
        @if($item->description)
            <div class="space-y-3 px-2">
                <p class="text-base leading-relaxed text-justify text-gray-700">{!! nl2br(e($item->description)) !!}</p>
            </div>
        @endif

        <div class="rounded-3xl bg-gray-50/70 p-6 text-sm text-gray-600">
            <div class="flex flex-col items-center gap-2">
                @if($item->activity_date)
                    <p><span class="font-semibold text-gray-900">Tanggal:</span> {{ $item->activity_date->translatedFormat('l, d F Y') }}</p>
                @endif
                @if($item->created_at)
                    <p><span class="font-semibold text-gray-900">Publikasi:</span> {{ $item->created_at->translatedFormat('d F Y') }}</p>
                @endif
            </div>
        </div>

        </section>

    @if($related->isNotEmpty())
        <section class="bg-gray-50 py-12">
            <div class="mx-auto max-w-5xl space-y-6 px-6 text-center">
                <h2 class="text-2xl font-semibold text-gray-900">Dokumentasi Terkait</h2>
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach($related as $relatedItem)
                        <article class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow">
                            @if($relatedItem->image_path)
                                <a href="{{ route('gallery.show', $relatedItem) }}" wire:navigate>
                                    <img src="{{ asset($relatedItem->image_path) }}" alt="{{ $relatedItem->title }}" class="h-48 w-full object-cover" loading="lazy">
                                </a>
                            @endif
                            <div class="space-y-2 px-4 py-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-500">
                                    {{ optional($relatedItem->activity_date)->translatedFormat('d M Y') ?: 'Jadwal menyusul' }}
                                </p>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('gallery.show', $relatedItem) }}" class="hover:text-emerald-600" wire:navigate>
                                        {{ $relatedItem->title }}
                                    </a>
                                </h3>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" data-navigate-once></script>
    <script wire:navigate>
        window.initGallerySwiper = window.initGallerySwiper || function () {
            const swiperEl = document.querySelector('.gallery-swiper');
            if (!swiperEl) return;

            // Pastikan Swiper lama di-destroy sebelum membuat yang baru
            if (swiperEl.swiper) {
                swiperEl.swiper.destroy(true, true);
            }

            new Swiper('.gallery-swiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 0,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        };

        // Fungsi pembungkus untuk menjalankan inisialisasi Swiper
        const runInit = () => {
             // Menggunakan setTimeout 50ms untuk memberi waktu DOM Livewire stabil setelah navigasi
            setTimeout(window.initGallerySwiper, 50); 
        };


        if (!window.__gallerySwiperListenersBound) {
            // Jalankan saat pertama kali halaman dimuat
            document.addEventListener('DOMContentLoaded', runInit);
            // Jalankan setiap kali Livewire melakukan navigasi soft
            document.addEventListener('livewire:navigated', runInit);
            window.__gallerySwiperListenersBound = true;
        }

        // Panggil saat script ini dimuat/diparsing (untuk memastikan inisialisasi pada load komponen)
        runInit();
    </script>
@endpush