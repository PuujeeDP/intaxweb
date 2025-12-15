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
    <section
        class="relative @if ($page->headerImage) @else bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 @endif overflow-hidden">
        @if ($page->headerImage)
            {{-- Header Image Background --}}
            <div class="absolute inset-0">
                <img src="{{ $page->headerImage->file_path }}" alt="{{ $title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"></div>
            </div>
        @else
            {{-- Animated Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="page-grid" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                            <circle cx="30" cy="30" r="1.5" fill="white" opacity="0.6" />
                            <line x1="30" y1="30" x2="60" y2="30" stroke="white"
                                stroke-width="0.5" opacity="0.4" />
                            <line x1="30" y1="30" x2="30" y2="60" stroke="white"
                                stroke-width="0.5" opacity="0.4" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#page-grid)" />
                </svg>
            </div>

            {{-- Floating Gradient Orbs --}}
            <div class="absolute inset-0 overflow-hidden opacity-20">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-300 rounded-full filter blur-3xl animate-pulse"
                    style="animation-delay: 1s;"></div>
            </div>
        @endif

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                @if (!$page->hide_title)
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">
                        {{ $title }}
                    </h1>
                @endif

                @if ($excerpt)
                    <p
                        class="text-xl md:text-2xl @if ($page->headerImage) text-gray-100 @else text-green-100 @endif mb-8 max-w-3xl mx-auto leading-relaxed">
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
@endsection
