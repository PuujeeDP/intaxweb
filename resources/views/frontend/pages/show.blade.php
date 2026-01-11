@extends('frontend.layouts.app')

@php
    $locale = app()->getLocale();
    $title = $page->translate('title', $locale) ?? $page->title;
    $excerpt = $page->translate('excerpt', $locale);
    $content = $page->translate('content', $locale) ?? $page->content;
    $metaTitle = $page->translate('meta_title', $locale) ?? $title;
    $metaDescription = $page->translate('meta_description', $locale) ?? Str::limit(strip_tags($content), 160);
    $isFullWidth = $page->template === 'full-width';
@endphp

@section('content')
    {{-- Modern Hero Section --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 50%, #7a0810 100%);">
        @if ($page->headerImage)
            {{-- Header Image Background --}}
            <div class="absolute inset-0">
                <img src="{{ $page->headerImage->file_path }}" alt="{{ $title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(212, 12, 25, 0.85) 0%, rgba(160, 10, 20, 0.9) 100%);"></div>
            </div>
        @else
            {{-- Hexagon Pattern Background --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="hexagon-pattern" x="0" y="0" width="56" height="100" patternUnits="userSpaceOnUse">
                            <polygon points="28,6 52,18 52,42 28,54 4,42 4,18" fill="none" stroke="white" stroke-width="0.5" opacity="0.6"/>
                            <polygon points="28,56 52,68 52,92 28,104 4,92 4,68" fill="none" stroke="white" stroke-width="0.5" opacity="0.6"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#hexagon-pattern)" />
                </svg>
            </div>

            {{-- Large Decorative Hexagons --}}
            <div class="absolute top-1/2 right-0 transform translate-x-1/3 -translate-y-1/2 opacity-10 hidden lg:block">
                <svg width="500" height="500" viewBox="0 0 100 100" fill="none">
                    <polygon points="50,5 95,27.5 95,72.5 50,95 5,72.5 5,27.5" stroke="white" stroke-width="0.5" fill="none"/>
                    <polygon points="50,15 85,32.5 85,67.5 50,85 15,67.5 15,32.5" stroke="white" stroke-width="0.3" fill="none"/>
                    <polygon points="50,25 75,37.5 75,62.5 50,75 25,62.5 25,37.5" stroke="white" stroke-width="0.2" fill="none"/>
                </svg>
            </div>

            <div class="absolute bottom-0 left-0 transform -translate-x-1/4 translate-y-1/4 opacity-10 hidden lg:block">
                <svg width="400" height="400" viewBox="0 0 100 100" fill="none">
                    <polygon points="50,5 95,27.5 95,72.5 50,95 5,72.5 5,27.5" stroke="white" stroke-width="0.5" fill="none"/>
                    <polygon points="50,15 85,32.5 85,67.5 50,85 15,67.5 15,32.5" stroke="white" stroke-width="0.3" fill="none"/>
                </svg>
            </div>

            {{-- Floating Gradient Orbs --}}
            <div class="absolute inset-0 overflow-hidden opacity-15">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-red-300 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>
        @endif

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                @if (!$page->hide_title)
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight" style="font-family: 'Open Sans', sans-serif;">
                        {{ $title }}
                    </h1>
                @endif

                @if ($excerpt)
                    <p class="text-xl md:text-2xl text-red-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                        {{ $excerpt }}
                    </p>
                @endif
            </div>
        </div>
    </section>



    {{-- Main Content Section --}}
    <article class="relative bg-gradient-to-b from-white via-gray-50/30 to-white">
        <div class="{{ $isFullWidth ? 'max-w-7xl' : 'max-w-7xl' }} mx-auto px-4 sm:px-6 lg:px-8 py-5 md:py-10">
            @if ($isFullWidth)
                {{-- Full Width Layout (No Sidebar) --}}
                @include('frontend.pages.partials.full-width-content')
            @else
                {{-- Default Layout with Sidebar --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        @include('frontend.pages.partials.page-content')
                    </div>

                    <aside class="lg:col-span-1 space-y-6">
                        @include('frontend.pages.partials.sidebar')
                    </aside>
                </div>
            @endif
        </div>
    </article>

    {{-- Team Section - Only show for "about" page --}}
    @if ($page->slug === 'about')
        @include('frontend.partials.team-section')
    @endif
@endsection
