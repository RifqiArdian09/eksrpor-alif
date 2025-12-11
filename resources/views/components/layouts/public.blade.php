<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @hasSection('title')
            <title>@yield('title') - {{ $siteName ?? config('app.name') }}</title>
        @else
            <title>{{ $siteName ?? config('app.name') }}</title>
        @endif

        <link rel="icon" href="{{ $logoUrl ?? asset('images/logo.png') }}" type="image/png" />
        <link rel="apple-touch-icon" href="{{ $logoUrl ?? asset('images/logo.png') }}" />
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=instrument-sans:300,400,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased overflow-x-hidden">
        @include('livewire.site.partials.nav', [
            'siteName' => $siteName ?? config('app.name'),
            'companyName' => $companyName ?? ($siteName ?? config('app.name')),
            'logoUrl' => $logoUrl ?? asset('images/logo.png'),
            'navigation' => $navigation ?? collect(),
        ])

        <main class="bg-white">
            {{ $slot }}
        </main>

        @include('livewire.site.partials.footer', [
            'siteName' => $siteName ?? config('app.name'),
            'companyName' => $companyName ?? ($siteName ?? config('app.name')),
            'logoUrl' => $logoUrl ?? asset('images/logo.png'),
            'settings' => $settings ?? collect(),
        ])

        @php
            use App\Models\Setting;

            $companyPhone = data_get($settings ?? [], 'company.phone');

            if (! $companyPhone) {
                $companyPhone = Setting::where('key', 'company.phone')->value('value');
            }

            $digitsOnly = $companyPhone ? preg_replace('/[^0-9]/', '', $companyPhone) : null;
        @endphp

        @if ($digitsOnly)
            <a
                href="https://wa.me/{{ $digitsOnly }}"
                target="_blank"
                rel="noopener noreferrer"
                class="fixed bottom-6 right-6 z-50 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-white px-5 py-2 text-xs font-semibold text-emerald-600 shadow-lg shadow-emerald-600/20 transition hover:border-emerald-400 hover:text-emerald-700"
            >
                <img src="{{ asset('images/whatsapp-svgrepo-com.svg') }}" alt="" class="h-6 w-6" />
                <span>Hubungi Kami</span>
            </a>
        @endif

        @stack('scripts')
    </body>
</html>
