@extends('frontend.layouts.app')

@php
    $metaTitle = __('frontend.contact_us') . ' | ' . config('app.name');
    $metaDescription = __('frontend.contact_subtitle');
@endphp

@section('content')
    {{-- Hero Section - Consistent with other pages --}}
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 50%, #7a0810 100%);">
        {{-- Hexagon Pattern Background --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hexagon-pattern-contact" x="0" y="0" width="56" height="100"
                        patternUnits="userSpaceOnUse">
                        <polygon points="28,6 52,18 52,42 28,54 4,42 4,18" fill="none" stroke="white" stroke-width="0.5"
                            opacity="0.6" />
                        <polygon points="28,56 52,68 52,92 28,104 4,92 4,68" fill="none" stroke="white"
                            stroke-width="0.5" opacity="0.6" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hexagon-pattern-contact)" />
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

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight"
                    style="font-family: 'Open Sans', sans-serif;">
                    {{ __('frontend.contact_us') }}
                </h1>
                <p class="text-xl text-red-100 max-w-2xl mx-auto">
                    {{ __('frontend.contact_subtitle') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Quick Contact Cards --}}
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Address Card --}}
                <div
                    class="group flex items-center p-6 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-lg transition-all duration-300 border border-transparent hover:border-[#d40c19]/20">
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center mr-4"
                        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">
                            {{ __('frontend.address') }}</h3>
                        <p class="text-gray-900 font-medium">{{ $contactAddress ?? 'Ulaanbaatar, Mongolia' }}</p>
                    </div>
                </div>

                {{-- Phone Card --}}
                <div
                    class="group flex items-center p-6 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-lg transition-all duration-300 border border-transparent hover:border-[#d40c19]/20">
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center mr-4"
                        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">
                            {{ __('frontend.phone') }}</h3>
                        <a href="tel:{{ $contactPhone ?? '+976 1234 5678' }}"
                            class="text-gray-900 font-medium hover:text-[#d40c19] transition">
                            {{ $contactPhone ?? '+976 1234 5678' }}
                        </a>
                    </div>
                </div>

                {{-- Email Card --}}
                <div
                    class="group flex items-center p-6 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-lg transition-all duration-300 border border-transparent hover:border-[#d40c19]/20">
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center mr-4"
                        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">
                            {{ __('frontend.email') }}</h3>
                        <a href="mailto:{{ $contactEmail ?? 'info@intax.mn' }}"
                            class="text-gray-900 font-medium hover:text-[#d40c19] transition">
                            {{ $contactEmail ?? 'info@intax.mn' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content: Form + Map --}}
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

                {{-- Contact Form --}}
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-10 border border-gray-100">
                        <div class="mb-8">
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">
                                {{ __('frontend.send_message') }}</h2>
                            <p class="text-gray-600">{{ __('frontend.fill_form_below') }}</p>
                        </div>

                        @if (session('success'))
                            <div
                                class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="font-medium">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if (session('error'))
                            <div
                                class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="font-medium">{{ session('error') }}</p>
                            </div>
                        @endif

                        <form action="{{ localized_route('contact.submit') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('frontend.your_name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#d40c19]/20 focus:border-[#d40c19] transition @error('name') border-red-500 @enderror"
                                        placeholder="{{ __('frontend.enter_your_name') }}">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('frontend.your_email') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#d40c19]/20 focus:border-[#d40c19] transition @error('email') border-red-500 @enderror"
                                        placeholder="{{ __('frontend.enter_your_email') }}">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Phone --}}
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('frontend.phone_number') }}
                                    </label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#d40c19]/20 focus:border-[#d40c19] transition @error('phone') border-red-500 @enderror"
                                        placeholder="{{ __('frontend.enter_phone') }}">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Subject --}}
                                <div>
                                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('frontend.subject') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#d40c19]/20 focus:border-[#d40c19] transition @error('subject') border-red-500 @enderror"
                                        placeholder="{{ __('frontend.enter_subject') }}">
                                    @error('subject')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Message --}}
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('frontend.message') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="message" name="message" rows="5" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#d40c19]/20 focus:border-[#d40c19] transition resize-none @error('message') border-red-500 @enderror"
                                    placeholder="{{ __('frontend.enter_message') }}">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- CAPTCHA --}}
                            <div>
                                <label for="captcha" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('frontend.captcha') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="bg-gray-100 px-5 py-3 rounded-xl border border-gray-200 font-mono text-lg font-bold text-gray-800 select-none">
                                        {{ $captcha['num1'] }} + {{ $captcha['num2'] }} = ?
                                    </div>
                                    <input type="number" id="captcha" name="captcha" required
                                        class="w-24 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#d40c19]/20 focus:border-[#d40c19] transition text-center @error('captcha') border-red-500 @enderror"
                                        placeholder="?">
                                </div>
                                @error('captcha')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full sm:w-auto text-white px-8 py-3.5 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
                                    {{ __('frontend.send_message') }}
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Sidebar: Office Info + Social --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Working Hours --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-[#d40c19] mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('frontend.working_hours') }}
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">{{ __('frontend.monday_friday') }}</span>
                                <span class="font-semibold text-gray-900">09:00 - 18:00</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">{{ __('frontend.saturday') }}</span>
                                <span class="font-semibold text-gray-900">10:00 - 14:00</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">{{ __('frontend.sunday') }}</span>
                                <span class="font-semibold text-[#d40c19]">{{ __('frontend.closed') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-[#d40c19] mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ __('frontend.follow_us') }}
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @if ($socialFacebook)
                                <a href="{{ $socialFacebook }}" target="_blank" rel="noopener noreferrer"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-[#d40c19] text-gray-600 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                            @endif
                            @if ($socialLinkedin)
                                <a href="{{ $socialLinkedin }}" target="_blank" rel="noopener noreferrer"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-[#d40c19] text-gray-600 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            @endif
                            @if ($socialTwitter)
                                <a href="{{ $socialTwitter }}" target="_blank" rel="noopener noreferrer"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-[#d40c19] text-gray-600 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                </a>
                            @endif
                            @if ($socialInstagram)
                                <a href="{{ $socialInstagram }}" target="_blank" rel="noopener noreferrer"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-[#d40c19] text-gray-600 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
                            @endif
                            @if ($socialYoutube)
                                <a href="{{ $socialYoutube }}" target="_blank" rel="noopener noreferrer"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-[#d40c19] text-gray-600 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Mini Map --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="h-60">
                            <iframe class="w-full h-full border-0" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&height=200&hl=en&q=UB%20Tower,Ulaanbaatar+(inTax)&t=&z=15&ie=UTF8&iwloc=B&output=embed"
                                loading="lazy">
                            </iframe>
                        </div>
                        <div class="p-4">
                            <a href="https://maps.app.goo.gl/ajtShLsz411PtnPG9" target="_blank"
                                class="inline-flex items-center text-sm text-[#d40c19] hover:text-[#a00a14] font-semibold">
                                {{ __('frontend.get_directions') }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
