@php
    $siteSettings = collect($settings ?? []);
    $contactEmail = $siteSettings->get('company.email');
    $contactPhone = $siteSettings->get('company.phone');
    $companyAddress = $siteSettings->get('company.address');
    $companySocials = collect($siteSettings->get('company.socials'));
@endphp

<footer class="border-t border-neutral-200 bg-neutral-50 py-12 text-sm text-neutral-600">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 md:grid-cols-[2fr_1fr_1fr] md:px-6">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-3">
                <img src="{{ $logoUrl ?? asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain" />
            </div>
            <p class="text-sm text-neutral-500">
                Platform pendampingan ekspor untuk UMKM Indonesia agar mampu bersaing di pasar global secara berkelanjutan.
            </p>
            @if($companySocials->filter()->isNotEmpty())
                <div class="flex flex-wrap gap-3 text-xs">
                    @foreach($companySocials->filter() as $label => $url)
                        <a href="{{ $url }}" target="_blank" class="rounded-full bg-white px-3 py-1 font-semibold text-emerald-600 shadow-sm ring-1 ring-neutral-200 hover:bg-emerald-50">
                            {{ ucfirst($label) }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-neutral-500">Navigasi</p>
            <ul class="mt-3 space-y-2 text-sm font-semibold">
                <li><a href="#about" class="text-neutral-600 transition hover:text-emerald-600">Tentang</a></li>
                <li><a href="#services" class="text-neutral-600 transition hover:text-emerald-600">Layanan</a></li>
                <li><a href="#products" class="text-neutral-600 transition hover:text-emerald-600">Produk</a></li>
                <li><a href="#contact" class="text-neutral-600 transition hover:text-emerald-600">Kontak</a></li>
            </ul>
        </div>

        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-neutral-500">Kontak Cepat</p>
            <div class="mt-3 space-y-2 text-sm">
                @if($contactEmail)
                    <p>Email: <a href="mailto:{{ $contactEmail }}" class="font-semibold text-emerald-600 hover:underline">{{ $contactEmail }}</a></p>
                @endif
                @if($contactPhone)
                    <p>Telepon: <span class="font-semibold text-neutral-900">{{ $contactPhone }}</span></p>
                @endif
                @if($companyAddress)
                    <p class="text-neutral-500">{{ $companyAddress }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-10 border-t border-neutral-200 pt-5 text-center text-xs text-neutral-500">
        © {{ now()->year }} {{ $siteName ?? config('app.name') }}. All rights reserved.
    </div>
</footer>
