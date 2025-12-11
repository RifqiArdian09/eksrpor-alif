<div class="bg-white">
    <section class="mx-auto max-w-5xl space-y-6 px-6 py-12 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-600">Dokumentasi</p>
        <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">Galeri Kegiatan</h1>
        <p class="mx-auto max-w-2xl text-sm text-gray-600">
            Ikuti rangkaian kegiatan ekspor, kolaborasi, dan pendampingan yang kami dokumentasikan secara singkat.
        </p>
        @if($items->total())
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">
                Menampilkan {{ $items->firstItem() }}-{{ $items->lastItem() }} dari {{ $items->total() }} dokumentasi
            </p>
        @endif
    </section>

    <section class="mx-auto max-w-6xl space-y-8 px-6 pb-16">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($items as $item)
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
                                <p class="text-xs text-neutral-200">{{ \Illuminate\Support\Str::limit($item->description, 110) }}</p>
                            @endif
                        </figcaption>
                    </figure>
                </a>
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-gray-200 bg-gray-50 p-10 text-center">
                    <p class="text-base font-semibold text-gray-900">Belum ada dokumentasi</p>
                    <p class="mt-2 text-sm text-gray-500">
                        Tim sedang mempersiapkan konten terbaru. Silakan kunjungi kembali nanti.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="flex justify-center">
            {{ $items->links() }}
        </div>
    </section>
</div>
