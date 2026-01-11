@extends('frontend.layouts.app')

@php
    $locale = app()->getLocale();
    $pageTitle = $page ? $page->translate('title', $locale) ?? $page->title : __('frontend.our_services');
    $pageExcerpt = $page ? $page->translate('excerpt', $locale) ?? '' : '';
    $pageContent = $page ? $page->translate('content', $locale) ?? '' : '';
    $metaTitle = $pageTitle . ' | ' . config('app.name');
    $metaDescription = $pageExcerpt ?: __('frontend.services_subtitle');
@endphp

@section('content')
    {{-- Modern Hero Section --}}
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 50%, #7a0810 100%);">
        @if ($page && $page->headerImage)
            {{-- Header Image Background --}}
            <div class="absolute inset-0">
                <img src="{{ $page->headerImage->url }}" alt="{{ $pageTitle }}" class="w-full h-full object-cover">
                <div class="absolute inset-0"
                    style="background: linear-gradient(135deg, rgba(212, 12, 25, 0.85) 0%, rgba(160, 10, 20, 0.9) 100%);">
                </div>
            </div>
        @else
            {{-- Hexagon Pattern Background --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="hexagon-pattern-services" x="0" y="0" width="56" height="100"
                            patternUnits="userSpaceOnUse">
                            <polygon points="28,6 52,18 52,42 28,54 4,42 4,18" fill="none" stroke="white"
                                stroke-width="0.5" opacity="0.6" />
                            <polygon points="28,56 52,68 52,92 28,104 4,92 4,68" fill="none" stroke="white"
                                stroke-width="0.5" opacity="0.6" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#hexagon-pattern-services)" />
                </svg>
            </div>

            {{-- Large Decorative Hexagons --}}
            <div class="absolute top-1/2 right-0 transform translate-x-1/3 -translate-y-1/2 opacity-10 hidden lg:block">
                <svg width="500" height="500" viewBox="0 0 100 100" fill="none">
                    <polygon points="50,5 95,27.5 95,72.5 50,95 5,72.5 5,27.5" stroke="white" stroke-width="0.5"
                        fill="none" />
                    <polygon points="50,15 85,32.5 85,67.5 50,85 15,67.5 15,32.5" stroke="white" stroke-width="0.3"
                        fill="none" />
                    <polygon points="50,25 75,37.5 75,62.5 50,75 25,62.5 25,37.5" stroke="white" stroke-width="0.2"
                        fill="none" />
                </svg>
            </div>

            {{-- Floating Gradient Orbs --}}
            <div class="absolute inset-0 overflow-hidden opacity-15">
                <div class="absolute -top-1/2 -left-1/4 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse">
                </div>
                <div class="absolute top-1/2 -right-1/4 w-96 h-96 bg-red-300 rounded-full filter blur-3xl animate-pulse"
                    style="animation-delay: 1s;"></div>
            </div>
        @endif

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight"
                    style="font-family: 'Open Sans', sans-serif;">
                    {{ $pageTitle }}
                </h1>

                @if ($pageExcerpt)
                    <p class="text-xl md:text-2xl text-red-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                        {{ $pageExcerpt }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    {{-- Page Content Section (from services page) --}}
    @if ($page && !empty(trim($pageContent)))
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="animate-fade-in-up">
                    <div
                        class="prose prose-lg max-w-none
                                prose-headings:font-bold prose-headings:text-gray-900
                                prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-6
                                prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4
                                prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-6
                                prose-a:text-[#d40c19] prose-a:font-medium hover:prose-a:text-[#a00a14]
                                prose-strong:text-gray-900 prose-strong:font-bold
                                prose-ul:list-disc prose-ul:ml-6 prose-ul:my-6 prose-ul:space-y-2 prose-ul:marker:text-[#d40c19]
                                prose-ol:list-decimal prose-ol:ml-6 prose-ol:my-6 prose-ol:space-y-2 prose-ol:marker:text-[#d40c19]
                                prose-li:my-2 prose-li:text-gray-700 prose-li:pl-2
                                prose-img:shadow-xl
                                prose-blockquote:border-l-4 prose-blockquote:border-[#d40c19] prose-blockquote:pl-4 prose-blockquote:italic
                                prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded
                                [&_iframe]:w-full [&_iframe]:aspect-video [&_iframe]:rounded-xl
                                [&>*]:mb-4 [&>p]:mb-6">
                        {!! $pageContent !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Services Grid Section --}}
    @include('frontend.services.partials.services-grid')
@endsection
