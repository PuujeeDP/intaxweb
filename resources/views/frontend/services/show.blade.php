@extends('frontend.layouts.app')

@php
    $metaTitle = $service->title . ' | ' . config('app.name');
    $metaDescription = $service->description ?? '';
    $ogImage = $service->featuredImage ? $service->featuredImage->url : null;
@endphp

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hero-grid" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
                        <circle cx="25" cy="25" r="1.5" fill="white" opacity="0.6" />
                        <line x1="25" y1="25" x2="50" y2="25" stroke="white" stroke-width="0.5"
                            opacity="0.4" />
                        <line x1="25" y1="25" x2="25" y2="50" stroke="white" stroke-width="0.5"
                            opacity="0.4" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-grid)" />
            </svg>
        </div>

        {{-- Floating Orbs --}}
        <div class="absolute inset-0 overflow-hidden opacity-20">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-300 rounded-full filter blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="max-w-4xl mx-auto text-center">
                {{-- Breadcrumb --}}
                <nav class="flex justify-center mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-sm text-green-100">
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

                {{-- Icon --}}
                @if ($service->icon)
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-6 border border-white/20">
                        <i class="{{ $service->icon }} text-4xl text-white"></i>
                    </div>
                @endif

                {{-- Title --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
                    {{ $service->title }}
                </h1>

                {{-- Description --}}
                @if ($service->description)
                    <p class="text-xl md:text-2xl text-green-100 max-w-5xl mx-auto leading-relaxed">
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
                    prose-a:text-green-600 prose-a:no-underline hover:prose-a:text-green-700 hover:prose-a:underline
                    prose-strong:text-gray-900 prose-strong:font-semibold
                    prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                    prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                    prose-li:text-gray-600 prose-li:mb-2
                    prose-img:rounded-xl prose-img:shadow-lg
                    prose-blockquote:border-l-4 prose-blockquote:border-green-600 prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700">
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
                                    :class="activeTab === {{ $index }} ? 'border-green-600 text-green-600' :
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
                                    prose-a:text-green-600 prose-a:no-underline hover:prose-a:text-green-700 hover:prose-a:underline
                                    prose-strong:text-gray-900 prose-strong:font-semibold
                                    prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                                    prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                                    prose-li:text-gray-600 prose-li:mb-2
                                    prose-img:rounded-xl prose-img:shadow-lg
                                    prose-blockquote:border-l-4 prose-blockquote:border-green-600 prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700">
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
                                <i class="{{ $contentSection->icon }} mr-3 text-green-600"></i>
                            @endif
                            {{ $contentSection->title }}
                        </h2>
                        <div
                            class="prose prose-lg max-w-none
                            prose-headings:font-bold prose-headings:text-gray-900
                            prose-h2:text-3xl prose-h2:mb-6 prose-h2:mt-12
                            prose-h3:text-2xl prose-h3:mb-4 prose-h3:mt-8
                            prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-6
                            prose-a:text-green-600 prose-a:no-underline hover:prose-a:text-green-700 hover:prose-a:underline
                            prose-strong:text-gray-900 prose-strong:font-semibold
                            prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                            prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                            prose-li:text-gray-600 prose-li:mb-2
                            prose-img:rounded-xl prose-img:shadow-lg
                            prose-blockquote:border-l-4 prose-blockquote:border-green-600 prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700">
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
                                        <i class="{{ $accordion->icon }} mr-3 text-green-600"></i>
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
                                        prose-a:text-green-600 prose-a:no-underline hover:prose-a:text-green-700 hover:prose-a:underline
                                        prose-strong:text-gray-900 prose-strong:font-semibold
                                        prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-6
                                        prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-6
                                        prose-li:text-gray-600 prose-li:mb-2
                                        prose-img:rounded-xl prose-img:shadow-lg
                                        prose-blockquote:border-l-4 prose-blockquote:border-green-600 prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-700">
                                        {!! $accordion->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif



            {{-- CTA Box --}}
            <div class="mt-12 p-10 bg-gradient-to-br from-green-600 to-emerald-700 rounded-2xl text-center shadow-2xl">
                <h3 class="text-3xl font-bold text-white mb-4">{{ __('frontend.interested_in_service') }}</h3>
                <p class="text-green-100 text-lg mb-8 max-w-2xl mx-auto">
                    {{ __('frontend.contact_us_for_details') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ localized_route('contact.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-600 rounded-xl font-bold text-lg hover:bg-green-50 transition transform hover:scale-105 shadow-lg">
                        {{ __('frontend.contact_us') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </a>
                    <a href="{{ localized_route('services.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-bold text-lg hover:bg-white/20 transition border-2 border-white/30">
                        {{ __('frontend.view_all_services') }}
                    </a>
                </div>
            </div>
        </div>
    </article>

    {{-- Related Services --}}
    @if ($relatedServices->count() > 0)
        <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ __('frontend.related_services') }}
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-400 to-emerald-600 mx-auto mb-4"></div>
                    <p class="text-lg text-gray-600">{{ __('frontend.you_might_also_like') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($relatedServices as $relatedService)
                        <article
                            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-green-300 transform hover:-translate-y-2">
                            @if ($relatedService->featuredImage)
                                <a href="{{ localized_route('services.show', ['slug' => $relatedService->slug]) }}"
                                    class="block relative">
                                    <div class="h-48 overflow-hidden bg-gradient-to-br from-green-100 to-emerald-100">
                                        <img src="{{ $relatedService->featuredImage->url }}"
                                            alt="{{ $relatedService->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div
                                    class="h-48 bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                                    @if ($relatedService->icon)
                                        <i class="{{ $relatedService->icon }} text-5xl text-white/80"></i>
                                    @endif
                                </div>
                            @endif

                            <div class="p-6">
                                @if ($relatedService->icon && $relatedService->featuredImage)
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-700 rounded-xl flex items-center justify-center mb-4 shadow-md">
                                        <i class="{{ $relatedService->icon }} text-xl text-white"></i>
                                    </div>
                                @endif

                                <h3
                                    class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors">
                                    <a href="{{ localized_route('services.show', ['slug' => $relatedService->slug]) }}">
                                        {{ $relatedService->title }}
                                    </a>
                                </h3>

                                @if ($relatedService->description)
                                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($relatedService->description, 120) }}
                                    </p>
                                @endif

                                <a href="{{ localized_route('services.show', ['slug' => $relatedService->slug]) }}"
                                    class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold group/link">
                                    {{ __('frontend.view_details') }}
                                    <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
