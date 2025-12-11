<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    @php
        use App\Models\Setting;
        use App\Models\HeroSection;
        use Illuminate\Support\Str;

        $settings = Setting::whereIn('key', [
            'company.name',
            'company.logo',
        ])->pluck('value', 'key');

        $siteName = $settings['company.name'] ?? config('app.name', 'Laravel');
        $logoUrl = $settings['company.logo'] ?? asset('images/logo.png');

        $primaryHero = HeroSection::first();
        $heroHasVideo = $primaryHero?->media_path && Str::of($primaryHero->media_path)->endsWith('.mp4');
        $heroBackgroundImage = null;

        if (! $heroHasVideo && $primaryHero?->media_path) {
            $heroBackgroundImage = asset($primaryHero->media_path);
        }

        $heroIsVisual = $heroHasVideo || $heroBackgroundImage;
        $brandTone = $heroIsVisual ? 'text-white' : 'text-gray-900';
        $brandAccent = $heroIsVisual ? 'text-emerald-200' : 'text-emerald-600';
        $bodyTone = $heroIsVisual ? 'text-white' : 'text-gray-900';
    @endphp
    <body class="relative min-h-screen antialiased {{ $heroIsVisual ? 'bg-neutral-950 text-white' : 'bg-gradient-to-br from-emerald-50 via-white to-slate-100 text-gray-900' }}">
        @if ($heroHasVideo)
            <div class="absolute inset-0">
                <video
                    class="h-full w-full object-cover"
                    autoplay
                    muted
                    loop
                    playsinline
                >
                    <source src="{{ asset($primaryHero->media_path) }}" type="video/mp4">
                </video>
            </div>
        @elseif ($heroBackgroundImage)
            <div
                class="absolute inset-0"
                style="background-image: url('{{ $heroBackgroundImage }}'); background-size: cover; background-position: center;"
            ></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-100 via-slate-50 to-slate-200"></div>
        @endif

        <div class="absolute inset-0 {{ $heroIsVisual ? 'bg-gradient-to-b from-black/70 via-black/60 to-black/80' : 'bg-gradient-to-b from-white/90 via-white/85 to-white/95' }}"></div>
        <div class="absolute inset-0 {{ $heroIsVisual ? 'bg-[radial-gradient(ellipse_at_top,_rgba(16,185,129,0.2),_transparent_55%)]' : 'bg-[radial-gradient(ellipse_at_top,_rgba(16,185,129,0.15),_transparent_45%)]' }}"></div>

        <div class="relative z-10 flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6 text-center">
               
                <div class="rounded-2xl bg-white/95 text-stone-800 shadow-2xl backdrop-blur-sm dark:bg-stone-950/95 dark:text-stone-100">
                    <div class="px-10 py-8 flex flex-col items-center gap-6">
                        <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                            <span class="flex items-center justify-center">
                                <img
                                    src="{{ $logoUrl }}"
                                    alt="{{ $siteName }}"
                                    class="h-16 w-auto max-w-full object-contain"
                                    loading="lazy"
                                />
                            </span>
                        </a>

                        <div class="w-full">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>