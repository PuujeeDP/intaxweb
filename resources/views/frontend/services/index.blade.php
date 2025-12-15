@extends('frontend.layouts.app')

@php
    $metaTitle = 'Үйлчилгээ | ' . config('app.name');
    $metaDescription = 'MagicCMS-ийн үзүүлдэг бүх төрлийн үйлчилгээнүүд - вэб хөгжүүлэлт, дизайн, зөвлөх үйлчилгээ';
@endphp

@section('content')
    {{-- Modern Hero Section --}}
    <section class="relative bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 overflow-hidden">
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="service-grid" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                        <circle cx="30" cy="30" r="1.5" fill="white" opacity="0.6" />
                        <line x1="30" y1="30" x2="60" y2="30" stroke="white" stroke-width="0.5"
                            opacity="0.4" />
                        <line x1="30" y1="30" x2="30" y2="60" stroke="white" stroke-width="0.5"
                            opacity="0.4" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#service-grid)" />
            </svg>
        </div>

        {{-- Floating Gradient Orbs --}}
        <div class="absolute inset-0 overflow-hidden opacity-20">
            <div class="absolute -top-1/2 -left-1/4 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute top-1/2 -right-1/4 w-96 h-96 bg-emerald-300 rounded-full filter blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">
                    {{ __('frontend.our_services') }}
                </h1>
                <p class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    {{ __('frontend.services_subtitle') }}
                </p>


            </div>
        </div>
    </section>

    {{-- Main Services Section --}}
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            @if ($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($services as $index => $service)
                        {{-- Modern Service Card --}}
                        <article
                            class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-green-300 transform hover:-translate-y-2"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                            {{-- Gradient Overlay on Hover --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-green-600/0 to-emerald-600/0 group-hover:from-green-600/5 group-hover:to-emerald-600/5 transition-all duration-500 pointer-events-none">
                            </div>

                            @if ($service->featuredImage)
                                <a href="{{ localized_route('services.show', ['slug' => $service->slug]) }}"
                                    class="block relative">
                                    <div class="h-56 overflow-hidden bg-gradient-to-br from-green-100 to-emerald-100">
                                        <img src="{{ $service->featuredImage->url }}" alt="{{ $service->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        {{-- Overlay --}}
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div
                                    class="h-56 bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                                    @if ($service->icon)
                                        <i class="{{ $service->icon }} text-6xl text-white/80"></i>
                                    @else
                                        <svg class="w-20 h-20 text-white/60" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    @endif
                                </div>
                            @endif

                            <div class="relative p-8">
                                {{-- Icon Badge --}}
                                @if ($service->icon && $service->featuredImage)
                                    <div class="absolute -top-6 left-8">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-green-600 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                            <i class="{{ $service->icon }} text-2xl text-white"></i>
                                        </div>
                                    </div>
                                @endif

                                <div class="{{ $service->icon && $service->featuredImage ? 'mt-4' : '' }}">
                                    <h3
                                        class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">
                                        <a href="{{ localized_route('services.show', ['slug' => $service->slug]) }}"
                                            class="flex items-start">
                                            {{ $service->title }}
                                        </a>
                                    </h3>

                                    @if ($service->description)
                                        <p class="text-gray-600 mb-6 leading-relaxed line-clamp-3">
                                            {{ Str::limit($service->description, 150) }}
                                        </p>
                                    @endif

                                    <a href="{{ localized_route('services.show', ['slug' => $service->slug]) }}"
                                        class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold group/link">
                                        {{ __('frontend.view_details') }}
                                        <svg class="w-5 h-5 ml-2 transform group-hover/link:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            {{-- Corner Accent --}}
                            <div
                                class="absolute top-0 right-0 w-20 h-20 transform translate-x-10 -translate-y-10 bg-green-600 rounded-full opacity-0 group-hover:opacity-10 transition-opacity duration-500">
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                {{-- Empty State with Better Design --}}
                <div class="text-center py-20">
                    <div
                        class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full mb-6">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('frontend.no_services') }}</h3>
                    <p class="text-lg text-gray-600 mb-8">{{ __('frontend.services_coming') }}</p>
                    <a href="{{ localized_route('contact.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                        {{ __('frontend.contact_us') }}
                    </a>
                </div>
            @endif
        </div>
    </section>



    {{-- Modern CTA Section --}}
    <section class="relative py-20 bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 overflow-hidden">
        {{-- Animated Background --}}
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-300 rounded-full filter blur-3xl animate-pulse"
                style="animation-delay: 1.5s;"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-12 md:p-16 border border-white/20 shadow-2xl">
                <div class="text-center">
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                        {{ __('frontend.ready_to_start') }}
                    </h2>
                    <p class="text-xl md:text-2xl text-green-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                        {{ __('frontend.free_consultation') }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">

                        <a href="{{ localized_route('contact.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-bold text-lg hover:bg-white/20 transition border-2 border-white/30">
                            {{ __('frontend.get_in_touch') }}
                        </a>
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="mt-12 pt-8 border-t border-white/20">
                        <div class="flex flex-wrap justify-center items-center gap-8 text-white/80">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-200 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">{{ __('frontend.free_quote') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-200 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">{{ __('frontend.fast_response') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-200 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">{{ __('frontend.expert_team') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
