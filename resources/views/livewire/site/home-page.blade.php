<div class="space-y-20 bg-white">
    @once
        <style>
            @keyframes testimonials-carousel {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }

            .testimonials-carousel-track {
                animation: testimonials-carousel 42s linear infinite;
            }

            .testimonials-carousel-track:hover {
                animation-play-state: paused;
            }
        </style>
    @endonce

    {{-- Hero Section --}}
    @php
        $heroHasVideo = $hero?->media_path && Str::of($hero->media_path)->endsWith('.mp4');
        $heroBackgroundImage = null;

        if (! $heroHasVideo && $hero?->media_path) {
            $heroBackgroundImage = asset($hero->media_path);
        } elseif ($gallery?->first()?->image_path) {
            $heroBackgroundImage = asset($gallery->first()->image_path);
        }

        $heroIsVisual = $heroHasVideo || $heroBackgroundImage;
        $companyLogo = $companyProfile['logo'] ?? ($contact['logo'] ?? asset('images/logo.png'));
        $companyName = $companyProfile['company_name'] ?? config('app.name');
    @endphp
    <section
        id="hero"
        class="relative overflow-hidden {{ $heroIsVisual ? 'bg-gray-950 text-white' : 'bg-white text-gray-900' }} min-h-[100vh]"
    >
        @if($heroHasVideo)
            <div class="absolute inset-0">
                <video
                    class="h-full w-full object-cover"
                    autoplay
                    muted
                    loop
                    playsinline
                >
                    <source src="{{ asset($hero->media_path) }}" type="video/mp4">
                </video>
            </div>
        @elseif($heroBackgroundImage)
            <div
                class="absolute inset-0"
                style="background-image: url('{{ $heroBackgroundImage }}'); background-size: cover; background-position: center;"
            ></div>
        @endif
        <div class="absolute inset-0 {{ $heroIsVisual ? 'bg-gradient-to-b from-black/60 via-black/50 to-black/70' : 'bg-white' }}"></div>
        <div class="absolute inset-0 {{ $heroIsVisual ? 'bg-[radial-gradient(ellipse_at_top,_rgba(16,185,129,0.25),_transparent_55%)]' : 'bg-transparent' }}"></div>
        <div class="absolute inset-0 {{ $heroIsVisual ? 'bg-[radial-gradient(circle_at_bottom_right,_rgba(5,150,105,0.2),_transparent_65%)]' : 'bg-transparent' }}"></div>
        
        <div class="relative mx-auto flex min-h-[95vh] max-w-6xl flex-col items-center gap-12 px-6 py-24 text-center lg:text-left lg:flex-row">
            <div class="order-2 flex-1 space-y-8 lg:order-1">
                @if($hero?->tagline)
                    <div class="flex justify-center lg:justify-start">
                        <div class="inline-flex items-center gap-2 rounded-full border {{ $heroIsVisual ? 'border-white/30 bg-white/10' : 'border-emerald-200 bg-emerald-50' }} px-5 py-2">
                            <span class="h-1.5 w-1.5 animate-pulse rounded-full {{ $heroIsVisual ? 'bg-white' : 'bg-emerald-600' }}"></span>
                            <p class="text-xs font-bold uppercase tracking-[0.3em] {{ $heroIsVisual ? 'text-white' : 'text-emerald-600' }}">
                                {{ $hero->tagline }}
                            </p>
                        </div>
                    </div>
                @endif

                <h1 class="text-4xl font-bold tracking-tight {{ $heroIsVisual ? 'text-white' : 'text-gray-900' }} sm:text-5xl lg:text-6xl lg:leading-tight">
                    {{ $hero->title ?? __('Membuka Peluang Ekspor Tanpa Ribet') }}
                </h1>

                @if($hero?->description)
                    <p class="mx-auto max-w-2xl text-lg leading-relaxed {{ $heroIsVisual ? 'text-white/80' : 'text-gray-600' }} lg:mx-0">
                        {{ $hero->description }}
                    </p>
                @endif

                <div class="flex w-full flex-col gap-4 pt-4 sm:flex-row sm:flex-wrap sm:items-center sm:justify-center lg:justify-start">
                    <a href="#location" class="group inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-600 px-7 py-3.5 text-center text-sm font-bold text-white shadow-lg shadow-emerald-600/30 transition-all hover:bg-emerald-700 hover:shadow-xl hover:shadow-emerald-600/40 sm:w-auto sm:justify-center">
                        {{ __('Jadwalkan Konsultasi') }}
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#services" class="inline-flex w-full items-center justify-center gap-2 rounded-full border {{ $heroIsVisual ? 'border-white/40 bg-white/10 text-white hover:border-white hover:bg-white/20' : 'border-gray-300 bg-white text-gray-700 hover:border-emerald-500 hover:bg-gray-50' }} px-7 py-3.5 text-center text-sm font-bold transition-all sm:w-auto sm:justify-center">
                        {{ __('Lihat Layanan') }}
                    </a>
                </div>
            </div>

            <div class="order-1 flex w-full max-w-md flex-1 flex-col items-center lg:order-2">
                <div class="w-full rounded-3xl p-10 text-left">
                    <div class="mt-6 flex items-center justify-center">
                        <img
                            src="{{ $companyLogo }}"
                            alt="{{ $companyName }}"
                            class="h-32 w-auto max-w-full object-contain drop-shadow-lg"
                            loading="lazy"
                        />
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    @if($partners?->isNotEmpty())
        {{-- About Section --}}
    <section id="about" class="mx-auto max-w-7xl px-6 py-16">
        <div class="grid gap-12 lg:grid-cols-[1.3fr_1fr] lg:items-center">
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('Tentang Kami') }}</p>
                </div>
                
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 lg:text-4xl">
                    {{ __('Mitra ekspor untuk UMKM yang ingin naik kelas') }}
                </h2>

                @if($about?->vision)
                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 transition-all hover:border-emerald-200 hover:shadow-lg">
                        <h3 class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">
                            <span class="h-1 w-1 rounded-full bg-emerald-600"></span>
                            {{ __('Visi') }}
                        </h3>
                        <p class="mt-3 leading-relaxed text-gray-600">{{ $about->vision }}</p>
                    </div>
                @endif

                @if($about?->mission)
                    @php
                        $missionItems = collect(preg_split('/[\r\n|]+/', (string) $about->mission))->filter(fn ($line) => trim($line) !== '');
                    @endphp
                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 transition-all hover:border-emerald-200 hover:shadow-lg">
                        <h3 class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">
                            <span class="h-1 w-1 rounded-full bg-emerald-600"></span>
                            {{ __('Misi') }}
                        </h3>
                        @if($missionItems->isNotEmpty())
                            <ol class="mt-3 space-y-2 text-left text-gray-600">
                                @foreach($missionItems as $index => $missionLine)
                                    <li class="leading-relaxed">{{ $missionLine }}</li>
                                @endforeach
                            </ol>
                        @else
                            <p class="mt-3 whitespace-pre-line leading-relaxed text-gray-600">{{ $about->mission }}</p>
                        @endif
                    </div>
                @endif

                @if($about?->content)
                    <div class="prose prose-gray max-w-none text-gray-600">
                        {!! Str::of($about->content)->markdown() !!}
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                @if($about?->image_path)
                    <div class="group relative overflow-hidden rounded-3xl border border-gray-200 bg-gray-50 shadow-2xl" style="aspect-ratio: 9/14;">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/20 via-transparent to-transparent opacity-60"></div>
                        <img src="{{ asset($about->image_path) }}" alt="About" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    </div>
                @endif
            </div>
        </div>
    </section>

    @php
        $serviceIconSet = [
            'user-group' => '<svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 20v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M20 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm0 12v-1.5a3.5 3.5 0 0 0-2.5-3.34"/></svg>',
            'document-text' => '<svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11h4m-4 4h4M6 11h.01M6 15h.01M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 3v6h6"/></svg>',
            'paper-airplane' => '<svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2Zm0 0v-8"/></svg>',
            'default' => '<svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/><circle cx="12" cy="12" r="9"/></svg>',
            'undername' => 'briefcase',
            'clearence' => 'building-office-2',
            'custom' => 'building-office-2',
            'supplier' => 'users',
            'contract' => 'document-check',
            'door' => 'home-modern',
            'project' => 'rocket-launch',
            'ocean' => 'globe-alt',
            'freight' => 'paper-airplane',
            'dokumen' => 'document-text',
            'legal' => 'scale',
            'lisensi' => 'book-open',
            'konsultasi' => 'user-group',
            'strategi' => 'presentation-chart-line',
            'logistik' => 'truck',
            'pengiriman' => 'arrow-path-rounded-square',
            'keuangan' => 'banknotes',
            'pemasaran' => 'megaphone',
            'produk' => 'cube',
            'riset' => 'magnifying-glass-circle',
            'pelatihan' => 'academic-cap',
            'audit' => 'clipboard-document-check',
        ];
    @endphp

    {{-- Services Section --}}
    <section id="services" class="bg-white py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('Layanan') }}</p>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 lg:text-4xl">
                        {{ __('Solusi end-to-end untuk perjalanan ekspor Anda') }}
                    </h2>
                </div>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($services as $service)
                    <article class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 transition-all hover:border-emerald-200 hover:shadow-xl">
                        <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-emerald-500/5 blur-3xl transition-all group-hover:bg-emerald-500/10"></div>
                        <div class="relative space-y-4">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-2xl">
                                @php
                                    $iconKey = Str::slug($service->icon ?? '');
                                    $iconSvg = str_replace('text-gray-600', 'text-emerald-600', $serviceIconSet[$iconKey] ?? $serviceIconSet['default']);
                                @endphp
                                {!! $iconSvg !!}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $service->title }}</h3>
                            <p class="leading-relaxed text-gray-600">{{ $service->description }}</p>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-500">{{ __('Layanan akan segera hadir.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section id="products" class="border-y border-gray-200 bg-white py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('Produk Unggulan') }}</p>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 lg:text-4xl">
                        {{ __('Portofolio komoditas yang kami dampingi') }}
                    </h2>
                </div>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($products as $product)
                    <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all hover:border-emerald-200 hover:shadow-xl">
                        @if($product->thumbnail_path)
                            <div class="relative h-56 w-full overflow-hidden bg-gray-100">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/20 via-transparent to-transparent opacity-60"></div>
                                <img src="{{ asset($product->thumbnail_path) }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="text-lg font-bold text-gray-900">{{ $product->title }}</h3>
                            <p class="mt-3 line-clamp-3 leading-relaxed text-gray-600">{{ $product->description }}</p>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-500">{{ __('Produk akan segera ditampilkan.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Keunggulan Section --}}
    @if($highlights?->isNotEmpty())
        <section id="advantages" class="border-y border-gray-200 bg-white py-24">
            <div class="mx-auto max-w-7xl space-y-12 px-6">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                            <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('Keunggulan') }}</p>
                        </div>
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 lg:text-4xl">
                            {{ __('Menguatkan fondasi ekspor secara menyeluruh') }}
                        </h2>
                    </div>
                   
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($highlights as $highlight)
                        <article class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 transition-all hover:border-emerald-200 hover:shadow-xl">
                            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-emerald-500/5 blur-2xl transition-all group-hover:bg-emerald-500/10"></div>
                            <h3 class="relative mt-4 text-lg font-bold text-gray-900">{{ $highlight->title }}</h3>
                            <p class="relative mt-3 leading-relaxed text-gray-600">{{ $highlight->description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials Section --}}
    <section id="testimonials" class="bg-white py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('Testimoni') }}</p>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 lg:text-4xl">
                        {{ __('Cerita sukses klien yang kami dampingi') }}
                    </h2>
                </div>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($testimonials as $testimonial)
                    <figure class="group flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-6 transition-all hover:border-emerald-200 hover:shadow-xl">
                        <div class="mb-4 text-emerald-400/40">
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                            </svg>
                        </div>
                        <blockquote class="flex-1 leading-relaxed text-gray-700">"{{ $testimonial->body }}"</blockquote>
                        <figcaption class="mt-6 flex items-center gap-4 border-t border-gray-200 pt-6">
                            <div class="relative h-12 w-12 overflow-hidden rounded-full border-2 border-gray-200 bg-gray-100">
                                @if($testimonial->photo_path)
                                    <img src="{{ asset($testimonial->photo_path) }}" alt="{{ $testimonial->name }}" class="h-full w-full object-cover" />
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $testimonial->name }}</p>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-600">{{ $testimonial->exported_item }}</p>
                            </div>
                        </figcaption>
                    </figure>
                @empty
                    <p class="text-gray-500">{{ __('Testimoni akan segera ditambahkan.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section id="gallery" class="border-y border-gray-200 bg-white py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('Dokumentasi Kegiatan') }}</p>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 lg:text-4xl">
                        {{ __('Momen penting bersama ekosistem ekspor') }}
                    </h2>
                </div>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($gallery as $item)
                    @php
                        $cover = $item->image_path;
                    @endphp
                    <a href="{{ route('gallery.show', $item) }}" class="group block rounded-2xl" wire:navigate>

                        <figure class="relative overflow-hidden rounded-2xl bg-neutral-900/5 shadow-md transition hover:shadow-xl">
                            @if($cover)
                                <img
                                    src="{{ asset($cover) }}"
                                    alt="{{ $item->title }}"
                                    class="h-72 w-full object-cover transition duration-500 group-hover:scale-105"
                                    loading="lazy"
                                />
                            @else
                                <div class="flex h-72 items-center justify-center bg-neutral-200 text-sm text-neutral-400">
                                    {{ __('Gambar belum tersedia') }}
                                </div>
                            @endif

                            <figcaption class="absolute inset-x-0 bottom-0 space-y-2 bg-gradient-to-t from-black/90 via-black/50 to-transparent p-4 text-white">
                                <h3 class="text-base font-bold leading-tight">{{ $item->title }}</h3>
                                @if($item->description)
                                    <p class="text-xs text-neutral-300">{{ Str::limit($item->description, 100) }}</p>
                                @endif
                            </figcaption>
                        </figure>
                    </a>
                @empty
                    <p class="text-gray-500">{{ __('Dokumentasi kegiatan akan segera ditampilkan.') }}</p>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center">
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-700 transition hover:border-emerald-400 hover:text-emerald-600" wire:navigate>
                    {{ __('Lihat Semua Galeri') }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Partners Section --}}
        <section id="partners" class="mx-auto max-w-7xl space-y-8 px-6">
            <div class="space-y-4 text-left">
                <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('FAQ') }}</p>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Dipercaya oleh jaringan perusahaan</h2>
                <p class="text-sm text-gray-500">Logo mitra ditampilkan tanpa animasi agar tetap fokus dan mudah dikenali.</p>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($partners as $partner)
                    <div class="flex h-24 items-center justify-center rounded-2xl border border-gray-200 bg-white/80 p-4">
                        @if($partner->logo_path)
                            <img src="{{ asset($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-full w-auto object-contain" loading="lazy">
                        @else
                            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-300">LOGO</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Lokasi Section --}}
    @php
        $companyName = $companyProfile['company_name'] ?? config('app.name');
        $companyAddress = $companyProfile['office_address'] ?? null;
        $mapQuery = rawurlencode($companyAddress ?: $companyName);
        $mapsUrl = "https://www.google.com/maps?q={$mapQuery}";
        $mapsEmbedUrl = "https://www.google.com/maps?q={$mapQuery}&output=embed";
        $socialLinks = $companyProfile['social_links'] ?? [];
        if (! is_array($socialLinks)) {
            $socialLinks = [];
        }

        $platforms = [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'tiktok' => 'TikTok',
            'twitter' => 'Twitter',
        ];
    @endphp

    <section id="location" class="bg-white py-24">
        <div class="mx-auto max-w-7xl space-y-12 px-6">
            <div class="space-y-4 text-left">
                <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">{{ __('Lokasi & Peta') }}</p>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 lg:text-4xl">
                    {{ __('Kantor & Area Layanan') }}
                </h2>
                <p class="max-w-2xl text-left text-gray-600">
                    {{ __('Temukan kantor pusat kami dan lihat jangkauan layanan melalui peta interaktif berikut.') }}
                </p>
            </div>

            <div class="grid items-center gap-10 lg:grid-cols-[1.4fr_1fr]">
                <div class="group relative overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-2xl">
                    
                    <div class="relative aspect-[4/3] w-full">
                        <iframe
                            src="{{ $mapsEmbedUrl }}"
                            title="Company location map"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="h-full w-full border-0"
                            allowfullscreen
                        ></iframe>
                        <noscript>
                            <div class="flex h-full items-center justify-center px-6 py-10 text-sm text-gray-600">
                                {{ __('Peta tidak dapat dimuat. Gunakan tombol Google Maps di panel informasi.') }}
                            </div>
                        </noscript>
                    </div>
                </div>

                <div class="flex flex-col gap-6 rounded-3xl border border-gray-200 bg-white p-8 shadow-xl">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-sm font-medium text-emerald-600">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4m-9 4v6" />
                                </svg>
                            </span>
                            {{ __('Alamat Kantor') }}
                        </div>

                        @if ($companyAddress)
                            <p class="text-sm leading-relaxed text-gray-700">
                                {{ $companyAddress }}
                            </p>
                        @else
                            <p class="text-sm leading-relaxed text-gray-500">
                                {{ __('Alamat kantor belum diatur. Perbarui pengaturan perusahaan untuk menampilkan lokasi lengkap.') }}
                            </p>
                        @endif

                        <dl class="space-y-4 text-sm text-gray-600">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M3 12h18M5 17h14" />
                                </svg>
                                <div>
                                    <dt class="text-xs uppercase tracking-[0.4em] text-gray-400">{{ __('Perusahaan') }}</dt>
                                    <dd class="font-semibold text-gray-900">{{ $companyName }}</dd>
                                </div>
                            </div>
                            @if ($contact['email'])
                                <div class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16v12H4z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7l8 5 8-5" />
                                    </svg>
                                    <div>
                                        <dt class="text-xs uppercase tracking-[0.4em] text-gray-400">{{ __('Email') }}</dt>
                                        <dd>{{ $contact['email'] }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if ($contact['phone'])
                                <div class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5l8 4v6l-8 4V5zm8 4l10-4v14l-10 4V9z" />
                                    </svg>
                                    <div>
                                        <dt class="text-xs uppercase tracking-[0.4em] text-gray-400">{{ __('Telepon') }}</dt>
                                        <dd>{{ $contact['phone'] }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if ($contact['office_hours'])
                                <div class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2" />
                                        <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                                    </svg>
                                    <div>
                                        <dt class="text-xs uppercase tracking-[0.4em] text-gray-400">{{ __('Jam Operasional') }}</dt>
                                        <dd>{{ $contact['office_hours'] }}</dd>
                                    </div>
                                </div>
                            @endif
                        </dl>
                    </div>

                    @if (! empty($socialLinks))
                        <div class="space-y-3">
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-gray-400">{{ __('Ikuti Kami') }}</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($platforms as $key => $label)
                                    @php $url = $socialLinks[$key] ?? null; @endphp
                                    @if ($url)
                                        <a href="{{ $url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-1.5 text-xs font-semibold text-gray-700 transition hover:border-gray-300 hover:text-gray-700">
                                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-[11px] font-bold text-gray-600">
                                                {{ Str::upper(Str::substr($label, 0, 1)) }}
                                            </span>
                                            {{ $label }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2 text-xs font-semibold text-white shadow-lg shadow-emerald-600/30 transition hover:shadow-emerald-600/40">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H7" />
                            </svg>
                            <span>{{ __('Buka di Google Maps') }}</span>
                        </a>
                        @if ($contact['phone'])
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact['phone']) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-emerald-200 px-5 py-2 text-xs font-semibold text-emerald-600 transition hover:border-emerald-400 hover:text-emerald-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16.5a5.5 5.5 0 01-8.25 4.764L5 21l1.736-4.64A5.5 5.5 0 1117.5 6.5" />
                                </svg>
                                {{ __('Chat WhatsApp') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
{{-- FAQ Section --}}
    @if($faqs?->isNotEmpty())
        <section id="faq" class="border-y border-gray-200 bg-white py-24">
            <div class="mx-auto max-w-7xl px-6">
                <div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr]">
                    <div class="space-y-4 text-left">
                        <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-4 py-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                            <p class="text-xs font-bold uppercase tracking-[0.3em] text-gray-600">{{ __('FAQ') }}</p>
                        </div>
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 lg:text-4xl">
                            {{ __('Pertanyaan umum dari pelaku UMKM ekspor') }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ __('Kumpulkan jawaban singkat sebelum menghubungi tim kami untuk konsultasi lebih lanjut.') }}
                        </p>
                    </div>

                    <div class="space-y-4">
                        @foreach($faqs as $faq)
                            <details class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all hover:border-emerald-200">
                                <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-bold text-gray-900 transition-colors hover:text-emerald-600">
                                    {{ $faq->question }}
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xl text-emerald-600 transition-transform group-open:rotate-45">+</span>
                                </summary>
                                <div class="border-t border-gray-200 px-6 pb-6 pt-4">
                                    <p class="leading-relaxed text-gray-600">{{ $faq->answer }}</p>
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>