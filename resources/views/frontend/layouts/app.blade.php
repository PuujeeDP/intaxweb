<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    @if ($siteFavicon)
        <link rel="icon" type="image/png" href="{{ $siteFavicon->url }}">
    @endif

    {{-- SEO Meta Tags --}}
    <title>{{ $metaTitle ?? ($siteName ?? 'inTax S Counsel') }}</title>
    <meta name="description"
        content="{{ $metaDescription ?? ($siteDescription ?? 'Татвар, Санхүү, Хууль зүйн Зөвлөгөө') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'татвар, санхүү, хууль, зөвлөгөө, intax' }}">

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

    {{-- Fonts - Open Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app-frontend.js'])

    {{-- Dynamic Primary Color CSS --}}
    <style>
        :root {
            --primary-color: {{ $primaryColor ?? '#d40c19' }};
            --primary-red: #d40c19;
            --primary-red-dark: #C41820;
            --primary-red-darker: #A01419;
            --accent-dark: #d40c19;
            --accent-charcoal: #2d2d2d;
            --gradient-red: linear-gradient(135deg, #d40c19 0%, #C41820 100%);
            --gradient-dark: linear-gradient(135deg, #d40c19 0%, #2d2d2d 100%);
            --shadow-red: 0 10px 40px rgba(227, 27, 35, 0.25);
            --transition-smooth: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Apply primary color overrides */
        .bg-green-600 {
            background-color: var(--primary-red) !important;
        }

        .hover\:bg-green-700:hover {
            background-color: var(--primary-red-dark) !important;
        }

        .text-green-600 {
            color: var(--primary-red) !important;
        }

        .text-green-500 {
            color: var(--primary-red) !important;
        }

        .hover\:text-green-500:hover {
            color: var(--primary-red) !important;
        }

        .hover\:text-green-600:hover {
            color: var(--primary-red) !important;
        }

        .border-green-600 {
            border-color: var(--primary-red) !important;
        }

        .border-t-4.border-green-600 {
            border-top-color: var(--primary-red) !important;
        }

        .focus\:ring-green-500:focus {
            --tw-ring-color: var(--primary-red) !important;
        }

        .focus\:ring-green-600:focus {
            --tw-ring-color: var(--primary-red) !important;
        }

        .focus\:border-green-600:focus {
            border-color: var(--primary-red) !important;
        }

        .from-green-600 {
            --tw-gradient-from: var(--primary-red) !important;
        }

        .to-emerald-800,
        .to-emerald-900 {
            --tw-gradient-to: var(--primary-red-dark) !important;
        }

        .via-green-700 {
            --tw-gradient-via: var(--primary-red-dark) !important;
        }

        /* Hero hexagon decoration */
        .hero-hexagon {
            position: absolute;
            right: -100px;
            top: 50%;
            transform: translateY(-50%);
            width: 600px;
            height: 600px;
            opacity: 0.05;
        }

        /* Section tag styling */
        .section-tag {
            display: inline-block;
            background: rgba(227, 27, 35, 0.1);
            color: var(--primary-red);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        /* Service card hover effect */
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-red);
            transform: scaleX(0);
            transition: var(--transition-smooth);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        /* Stat card left border effect */
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-red);
            transform: scaleY(0);
            transition: var(--transition-smooth);
        }

        .stat-card:hover::before {
            transform: scaleY(1);
        }

        /* Floating badge */
        .floating-badge {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: var(--gradient-red);
            color: white;
            padding: 24px 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--shadow-red);
        }

        /* About card hover */
        .about-card:hover {
            border-color: var(--primary-red);
            transform: translateY(-5px);
            background: rgba(227, 27, 35, 0.05);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Font families */
        h1,
        h2,
        h3,
        h4 {
            font-family: 'Open Sans', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-white">


    {{-- Navigation --}}
    @include('frontend.layouts.partials.header')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.partials.footer')

    {{-- Scroll to Top Button --}}
    <div x-data="{ show: false }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2" @scroll.window="show = (window.pageYOffset > 300)"
        class="fixed bottom-8 right-8 z-50" style="display: none;">
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="w-12 h-12 bg-intax-red hover:bg-intax-red-dark text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            style="background-color: #d40c19;" aria-label="Scroll to top">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                </path>
            </svg>
        </button>
    </div>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        const header = document.querySelector('.header-main');
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    header.style.boxShadow = '0 4px 30px rgba(227, 27, 35, 0.1)';
                } else {
                    header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.05)';
                }
            });
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });
    </script>

    @stack('scripts')
</body>

</html>
