@extends('frontend.layouts.app')

@php
    $metaTitle = $service->title . ' | ' . config('app.name');
    $metaDescription = $service->description ?? '';
    $ogImage = $service->featuredImage ? $service->featuredImage->url : null;
@endphp

@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 50%, #7a0810 100%);">
        {{-- Hexagon Pattern Background --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hexagon-pattern-service" x="0" y="0" width="56" height="100"
                        patternUnits="userSpaceOnUse">
                        <polygon points="28,6 52,18 52,42 28,54 4,42 4,18" fill="none" stroke="white" stroke-width="0.5"
                            opacity="0.6" />
                        <polygon points="28,56 52,68 52,92 28,104 4,92 4,68" fill="none" stroke="white"
                            stroke-width="0.5" opacity="0.6" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hexagon-pattern-service)" />
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

        {{-- Floating Orbs --}}
        <div class="absolute inset-0 overflow-hidden opacity-15">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-red-300 rounded-full filter blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="max-w-4xl mx-auto text-center">
                {{-- Breadcrumb --}}
                <nav class="flex justify-center mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-sm text-red-100">
                        <li class="inline-flex items-center">
                            <a href="{{ localized_route('home') }}" class="hover:text-white transition">
                                {{ __('frontend.home') }}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <a href="{{ localized_route('services.index') }}" class="hover:text-white transition">
                                    {{ __('frontend.services') }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-white font-medium">{{ Str::limit($service->title, 30) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>



                {{-- Title --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight"
                    style="font-family: 'Open Sans', sans-serif;">
                    {{ $service->title }}
                </h1>

                {{-- Description --}}
                @if ($service->description)
                    <p class="text-xl md:text-2xl text-red-100 max-w-5xl mx-auto leading-relaxed">
                        {{ $service->description }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    {{-- Featured Image Section --}}
    @if ($service->featuredImage)
        <section class="relative -mt-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ $service->featuredImage->url }}" alt="{{ $service->title }}"
                        class="w-full h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- Content Section --}}
    <article class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($service->content)
                <div
                    class="prose prose-lg max-w-none
                    prose-headings:font-bold prose-headings:text-gray-900
                    prose-h2:text-3xl prose-h2:mb-6 prose-h2:mt-12
                    prose-h3:text-2xl prose-h3:mb-4 prose-h3:mt-8
                    prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-6
                    prose-a:text-[#d40c19] prose-a:no-underline hover:prose-a:text-[#a00a14] hover:prose-a:underline
                    prose-strong:text-gray-900 prose-strong:font-semibold
                    prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                    prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                    prose-li:text-gray-600 prose-li:mb-2
                    prose-img:rounded-xl prose-img:shadow-lg
                    prose-blockquote:border-l-4 prose-blockquote:border-[#d40c19] prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700
                    [&_iframe]:w-full [&_iframe]:aspect-video [&_iframe]:rounded-xl">
                    {!! $service->content !!}
                </div>
            @endif

            {{-- Tabs Section --}}
            @php
                $tabs = $service->sections->where('type', 'tab')->where('is_active', true);
            @endphp
            @if ($tabs->count() > 0)
                <div class="mt-5" x-data="{ activeTab: 0 }">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                            @foreach ($tabs as $index => $tab)
                                <button @click="activeTab = {{ $index }}"
                                    :class="activeTab === {{ $index }} ? 'border-[#d40c19] text-[#d40c19]' :
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                    @if ($tab->icon)
                                        <i class="{{ $tab->icon }} mr-2"></i>
                                    @endif
                                    {{ $tab->title }}
                                </button>
                            @endforeach
                        </nav>
                    </div>
                    <div class="mt-8">
                        @foreach ($tabs as $index => $tab)
                            <div x-show="activeTab === {{ $index }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0">
                                <div
                                    class="prose prose-lg max-w-none
                                    prose-headings:font-bold prose-headings:text-gray-900
                                    prose-h2:text-3xl prose-h2:mb-6 prose-h2:mt-12
                                    prose-h3:text-2xl prose-h3:mb-4 prose-h3:mt-8
                                    prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-6
                                    prose-a:text-[#d40c19] prose-a:no-underline hover:prose-a:text-[#a00a14] hover:prose-a:underline
                                    prose-strong:text-gray-900 prose-strong:font-semibold
                                    prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                                    prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                                    prose-li:text-gray-600 prose-li:mb-2
                                    prose-img:rounded-xl prose-img:shadow-lg
                                    prose-blockquote:border-l-4 prose-blockquote:border-[#d40c19] prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700
                                    [&_iframe]:w-full [&_iframe]:aspect-video [&_iframe]:rounded-xl">
                                    {!! $tab->content !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Additional Content Sections --}}
            @php
                $contentSections = $service->sections->where('type', 'content')->where('is_active', true);
            @endphp
            @if ($contentSections->count() > 0)
                @foreach ($contentSections as $contentSection)
                    <div class="mt-16">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            @if ($contentSection->icon)
                                <i class="{{ $contentSection->icon }} mr-3 text-[#d40c19]"></i>
                            @endif
                            {{ $contentSection->title }}
                        </h2>
                        <div
                            class="prose prose-lg max-w-none
                            prose-headings:font-bold prose-headings:text-gray-900
                            prose-h2:text-3xl prose-h2:mb-6 prose-h2:mt-12
                            prose-h3:text-2xl prose-h3:mb-4 prose-h3:mt-8
                            prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-6
                            prose-a:text-[#d40c19] prose-a:no-underline hover:prose-a:text-[#a00a14] hover:prose-a:underline
                            prose-strong:text-gray-900 prose-strong:font-semibold
                            prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                            prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                            prose-li:text-gray-600 prose-li:mb-2
                            prose-img:rounded-xl prose-img:shadow-lg
                            prose-blockquote:border-l-4 prose-blockquote:border-[#d40c19] prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700">
                            {!! $contentSection->content !!}
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Accordions Section --}}
            @php
                $accordions = $service->sections->where('type', 'accordion')->where('is_active', true);
            @endphp
            @if ($accordions->count() > 0)
                <div class="mt-12 space-y-4" x-data="{ openAccordion: null }">
                    @foreach ($accordions as $index => $accordion)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button
                                @click="openAccordion = openAccordion === {{ $index }} ? null : {{ $index }}"
                                class="w-full px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors flex justify-between items-center">
                                <span class="font-semibold text-gray-900 text-lg flex items-center">
                                    @if ($accordion->icon)
                                        <i class="{{ $accordion->icon }} mr-3 text-[#d40c19]"></i>
                                    @endif
                                    {{ $accordion->title }}
                                </span>
                                <svg :class="openAccordion === {{ $index }} ? 'transform rotate-180' : ''"
                                    class="w-5 h-5 text-gray-500 transition-transform duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openAccordion === {{ $index }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-screen"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 max-h-screen"
                                x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden">
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                    <div
                                        class="prose prose-lg max-w-none
                                        prose-headings:font-bold prose-headings:text-gray-900
                                        prose-h2:text-3xl prose-h2:mb-6 prose-h2:mt-12
                                        prose-h3:text-2xl prose-h3:mb-4 prose-h3:mt-8
                                        prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-6
                                        prose-a:text-[#d40c19] prose-a:no-underline hover:prose-a:text-[#a00a14] hover:prose-a:underline
                                        prose-strong:text-gray-900 prose-strong:font-semibold
                                        prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                                        prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                                        prose-li:text-gray-600 prose-li:mb-2
                                        prose-img:rounded-xl prose-img:shadow-lg
                                        prose-blockquote:border-l-4 prose-blockquote:border-[#d40c19] prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700">
                                        {!! $accordion->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif




        </div>
    </article>

    {{-- Related Services - Same style as Home page --}}
    @if ($relatedServices->count() > 0)
        <section class="py-20 lg:py-28 bg-white relative">
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-gray-50 to-transparent"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-5"
                        style="font-family: 'Open Sans', sans-serif;">
                        {{ __('frontend.related_services') }}
                    </h2>
                    <p class="text-gray-600">{{ __('frontend.you_might_also_like') }}</p>
                </div>

                {{-- Services Grid --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($relatedServices as $relatedService)
                        @php
                            $locale = app()->getLocale();
                            $relatedTitle = $relatedService->translate('title', $locale) ?? $relatedService->title;
                            $relatedDescription =
                                $relatedService->translate('description', $locale) ?? $relatedService->description;
                        @endphp

                        <a href="{{ localized_route('services.show', ['slug' => $relatedService->slug]) }}"
                            class="service-card animate-fade-in-up relative bg-white p-8 rounded-2xl text-center transition-all duration-300 border border-gray-100 hover:-translate-y-2 hover:shadow-xl hover:border-transparent overflow-hidden group"
                            style="animation-delay: {{ $loop->index * 0.05 }}s;">
                            <div class="w-[75px] h-[75px] mx-auto mb-5 rounded-full flex items-center justify-center text-3xl transition-all duration-300 group-hover:scale-110"
                                style="background: linear-gradient(135deg, rgba(212, 12, 25, 0.08) 0%, rgba(212, 12, 25, 0.15) 100%);">
                                <span
                                    class="group-hover:brightness-0 group-hover:invert transition-all">{{ $relatedService->icon ?? '📋' }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-[#d40c19] transition-colors duration-300"
                                style="font-family: 'Open Sans', sans-serif;">
                                {{ $relatedTitle }}
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($relatedDescription), 100) }}
                            </p>
                        </a>
                    @endforeach
                </div>

                {{-- View All Services Button --}}
                <div class="text-center mt-12">
                    <a href="{{ localized_route('services.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 text-white font-semibold rounded-md transition-all duration-300 hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%); box-shadow: 0 4px 15px rgba(212, 12, 25, 0.3);">
                        {{ __('frontend.view_all_services') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
