@extends('frontend.layouts.app')

@php
    $metaTitle = 'Манай баг | ' . config('app.name');
    $metaDescription = 'MagicCMS-ийн багийн гишүүд - Мэргэжлийн хамт олон';
@endphp

@section('content')
    {{-- Modern Hero Section --}}
    <section
        class="relative bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 text-white py-24 md:py-32 overflow-hidden">
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="tech-grid" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
                        <circle cx="25" cy="25" r="1" fill="white" opacity="0.5" />
                        <line x1="25" y1="25" x2="50" y2="25" stroke="white" stroke-width="0.5"
                            opacity="0.3" />
                        <line x1="25" y1="25" x2="25" y2="50" stroke="white" stroke-width="0.5"
                            opacity="0.3" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#tech-grid)" />
            </svg>
        </div>

        {{-- Floating Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in-up">
                {{ __('frontend.our_team_page') }}
            </h1>
            <p class="text-xl md:text-2xl text-green-100 max-w-3xl mx-auto animate-fade-in-up"
                style="animation-delay: 0.2s;">
                {{ __('frontend.team_subtitle') }}
            </p>
        </div>
    </section>

    {{-- Team Members Section with Modern Design --}}
    <section class="py-20 bg-gradient-to-b from-white via-gray-50/50 to-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-in-up" style="animation-delay: 0.3s;">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ __('frontend.our_team') }}</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ __('frontend.our_team_subtitle') }}</p>
            </div>

            @if ($teamMembers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" x-data="{ activeCard: null }">
                    @foreach ($teamMembers as $index => $member)
                        <div class="animate-fade-in-up" style="animation-delay: {{ ($index % 4) * 0.1 + 0.4 }}s;"
                            @mouseenter="activeCard = {{ $index }}" @mouseleave="activeCard = null">
                            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group"
                                :class="activeCard === {{ $index }} ? 'scale-105' : ''">
                                {{-- Gradient Overlay on Hover --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-green-600/0 via-green-600/0 to-green-600/90 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10 pointer-events-none">
                                </div>

                                {{-- Photo Container --}}
                                <div class="relative p-6 pb-0">
                                    <div
                                        class="w-40 h-40 mx-auto bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 rounded-full p-1 shadow-xl group-hover:scale-105 transition-transform duration-500">
                                        @if ($member->photo)
                                            <img src="{{ $member->photo->url }}"
                                                alt="{{ $member->name }}" class="w-full h-full rounded-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full bg-white rounded-full flex items-center justify-center">
                                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Member Info --}}
                                <div class="relative p-6 pt-4 z-20">
                                    <h3
                                        class="text-xl font-bold text-gray-900 group-hover:text-white transition-colors duration-300">
                                        {{ $member->name }}
                                    </h3>

                                    @if ($member->position)
                                        <p
                                            class="text-green-600 font-medium text-sm mt-1 group-hover:text-green-200 transition-colors duration-300">
                                            {{ $member->position }}
                                        </p>
                                    @endif

                                    @if ($member->bio)
                                        <p
                                            class="text-gray-600 text-sm leading-relaxed mt-3 line-clamp-3 group-hover:text-white/90 transition-colors duration-300">
                                            {{ Str::limit($member->bio, 100) }}
                                        </p>
                                    @endif

                                    {{-- Contact Info - Hidden by default, shown on hover --}}
                                    <div
                                        class="mt-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        @if ($member->email)
                                            <a href="mailto:{{ $member->email }}"
                                                class="flex items-center text-sm text-white/90 hover:text-white">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ Str::limit($member->email, 25) }}
                                            </a>
                                        @endif

                                        @if ($member->phone)
                                            <a href="tel:{{ $member->phone }}"
                                                class="flex items-center text-sm text-white/90 hover:text-white">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                                {{ $member->phone }}
                                            </a>
                                        @endif
                                    </div>

                                    {{-- Social Links --}}
                                    @if ($member->facebook || $member->twitter || $member->linkedin)
                                        <div
                                            class="flex justify-center space-x-3 mt-4 pt-4 border-t border-gray-200 group-hover:border-white/20 transition-colors duration-300">
                                            @if ($member->facebook)
                                                <a href="{{ $member->facebook }}" target="_blank" rel="noopener noreferrer"
                                                    class="w-9 h-9 bg-gray-100 group-hover:bg-white rounded-full flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all duration-300 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                    </svg>
                                                </a>
                                            @endif

                                            @if ($member->twitter)
                                                <a href="{{ $member->twitter }}" target="_blank" rel="noopener noreferrer"
                                                    class="w-9 h-9 bg-gray-100 group-hover:bg-white rounded-full flex items-center justify-center text-gray-600 hover:text-blue-400 transition-all duration-300 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                    </svg>
                                                </a>
                                            @endif

                                            @if ($member->linkedin)
                                                <a href="{{ $member->linkedin }}" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="w-9 h-9 bg-gray-100 group-hover:bg-white rounded-full flex items-center justify-center text-gray-600 hover:text-blue-700 transition-all duration-300 hover:scale-110">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-16 animate-fade-in-up">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-gray-900">{{ __('frontend.no_team_members') }}</h3>
                    <p class="mt-2 text-gray-600">{{ __('frontend.team_members_coming') }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA Section with Modern Effects --}}
    <section class="relative py-24 bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 overflow-hidden">
        {{-- Animated Background Elements --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="animate-fade-in-up">
                    <h2 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        {{ __('frontend.work_with_us') }}
                    </h2>
                    <p class="text-xl md:text-2xl text-green-100 mb-10 max-w-3xl mx-auto leading-relaxed">
                        {{ __('frontend.contact_for_details') }}
                    </p>
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ localized_route('contact.index') }}"
                        class="group inline-flex items-center space-x-3 bg-white text-green-600 px-10 py-5 rounded-2xl text-lg font-bold hover:bg-green-50 transition-all duration-300 shadow-2xl hover:shadow-3xl hover:scale-105">
                        <span>{{ __('frontend.get_in_touch') }}</span>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
