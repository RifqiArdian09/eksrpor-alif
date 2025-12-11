<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

@php
    $companyLogo = null;
    try {
        $settings = \App\Models\Setting::where('key', 'company.logo')->first();
        $companyLogo = $settings?->value;
    } catch (\Exception $e) {
        // Jika table belum ada atau error, gunakan default
    }
@endphp

@if($companyLogo)
    <link rel="icon" href="{{ asset($companyLogo) }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset($companyLogo) }}">
@else
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
@endif

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
