<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    @if($siteFavicon)
        <link rel="icon" type="image/png" href="{{ $siteFavicon->url }}">
    @endif

    {{-- SEO Meta Tags --}}
    <title>{{ $metaTitle ?? $siteName ?? config('app.name', 'MagicCMS') }}</title>
    <meta name="description" content="{{ $metaDescription ?? $siteDescription ?? 'Multi-language Content Management System' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'cms, laravel, blog' }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? config('app.name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? '' }}">
    @isset($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endisset

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $metaTitle ?? config('app.name') }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? '' }}">
    @isset($ogImage)
        <meta property="twitter:image" content="{{ $ogImage }}">
    @endisset

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app-frontend.js'])

    {{-- Dynamic Primary Color CSS --}}
    <style>
        :root {
            --primary-color: {{ $primaryColor ?? '#dc2626' }};
        }

        /* Apply primary color to green-600 classes */
        .bg-green-600 { background-color: var(--primary-color) !important; }
        .hover\:bg-green-700:hover { background-color: var(--primary-color) !important; filter: brightness(0.9); }
        .text-green-600 { color: var(--primary-color) !important; }
        .text-green-500 { color: var(--primary-color) !important; }
        .hover\:text-green-500:hover { color: var(--primary-color) !important; }
        .hover\:text-green-600:hover { color: var(--primary-color) !important; }
        .border-green-600 { border-color: var(--primary-color) !important; }
        .border-t-4.border-green-600 { border-top-color: var(--primary-color) !important; }
        .focus\:ring-green-500:focus { --tw-ring-color: var(--primary-color) !important; }
        .focus\:ring-green-600:focus { --tw-ring-color: var(--primary-color) !important; }
        .focus\:border-green-600:focus { border-color: var(--primary-color) !important; }

        /* Gradient backgrounds */
        .bg-gradient-to-r.from-green-600 {
            background: linear-gradient(to right, var(--primary-color), var(--primary-color)) !important;
            filter: brightness(0.95);
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    {{-- Navigation --}}
    @include('frontend.layouts.partials.header')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.partials.footer')

    @stack('scripts')
</body>
</html>
