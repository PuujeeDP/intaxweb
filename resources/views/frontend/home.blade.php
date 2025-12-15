@extends('frontend.layouts.app')

@section('content')
    {{-- Hero Slider Section --}}
    @if ($sliders->count() > 0)
        <section class="relative overflow-hidden" x-data="{
            currentSlide: 0,
            totalSlides: {{ $sliders->count() }},
            autoplay: null,
            init() {
                this.startAutoplay();
            },
            startAutoplay() {
                this.autoplay = setInterval(() => {
                    this.nextSlide();
                }, 5000);
            },
            stopAutoplay() {
                if (this.autoplay) {
                    clearInterval(this.autoplay);
                }
            },
            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            },
            prevSlide() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            },
            goToSlide(index) {
                this.currentSlide = index;
                this.stopAutoplay();
                this.startAutoplay();
            }
        }" @mouseenter="stopAutoplay()"
            @mouseleave="startAutoplay()">
            {{-- Slides Container --}}
            <div class="relative h-[500px] md:h-[600px] lg:h-[700px]">
                @foreach ($sliders as $index => $slider)
                    <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-1000"
                        x-transition:enter-start="opacity-0 transform scale-105"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="absolute inset-0" style="display: none;">

                        {{-- Background Image --}}
                        @if ($slider->image)
                            <div class="absolute inset-0">
                                <img src="{{ $slider->image->url }}" alt="{{ $slider->title }}"
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent">
                                </div>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-green-700 to-emerald-900">
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
                            <div class="max-w-3xl text-white">
                                @if ($slider->subtitle)
                                    <div
                                        class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full mb-6 border border-white/20">
                                        <span class="text-sm md:text-base font-semibold">{{ $slider->subtitle }}</span>
                                    </div>
                                    <h1
                                        class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight drop-shadow-2xl">
                                        {{ $slider->title }}
                                    </h1>
                                @endif



                                @if ($slider->description)
                                    <p class="text-lg md:text-xl text-gray-200 mb-8 leading-relaxed">
                                        {{ $slider->description }}
                                    </p>
                                @endif

                                @if ($slider->button_text && $slider->button_url)
                                    <div class="flex flex-wrap gap-4">
                                        <a href="{{ $slider->button_url }}"
                                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-600 rounded-xl font-bold text-lg hover:bg-green-50 transition transform hover:scale-105 shadow-xl"
                                            @if ($slider->button_target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $slider->button_text }}
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Navigation Arrows --}}
            @if ($sliders->count() > 1)
                <button @click="prevSlide()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition z-10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="nextSlide()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition z-10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                {{-- Pagination Dots --}}
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-10">
                    @foreach ($sliders as $index => $slider)
                        <button @click="goToSlide({{ $index }})"
                            :class="currentSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50 w-3'"
                            class="h-3 rounded-full transition-all duration-300 hover:bg-white"></button>
                    @endforeach
                </div>
            @endif


        </section>
    @else
        {{-- Fallback Hero Section if no sliders --}}
        {{-- Modern Hero Section with Gradient --}}
        <section class="relative bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 overflow-hidden">
            {{-- Technology Grid Pattern Background --}}
            <div class="absolute inset-0 opacity-20 ">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="tech-grid" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
                            <circle cx="25" cy="25" r="1" fill="white" opacity="0.5" />
                            <line x1="25" y1="25" x2="50" y2="25" stroke="white"
                                stroke-width="0.5" opacity="0.3" />
                            <line x1="25" y1="25" x2="25" y2="50" stroke="white"
                                stroke-width="0.5" opacity="0.3" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#tech-grid)" />
                </svg>
            </div>

            {{-- Animated Glow Effects --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"
                    style="animation-delay: 1s;"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
                <div class="text-center relative">


                    {{-- Main Heading with Floating Office 365 Logos --}}
                    <div class="relative inline-block">
                        {{-- Floating Office 365 App Icons --}}
                        <div class="absolute inset-0 pointer-events-none">
                            {{-- Word Icon (Top Left) --}}
                            <div class="absolute -left-20 -top-10 md:-left-32 md:-top-16 animate-float"
                                style="animation-delay: 0s;">
                                <div class="transform hover:scale-110 transition backround-white">
                                    <img src="{{ asset('images/icons/magic-finance-logo.svg') }}" alt="Magic Finance"
                                        class="w-12 h-12 md:w-16 md:h-16 drop-shadow-2xl  rounded-lg">
                                </div>
                            </div>

                            {{-- Excel Icon (Top Right) --}}
                            <div class="absolute -right-20 -top-8 md:-right-32 md:-top-12 animate-float"
                                style="animation-delay: 0.5s;">
                                <div class="transform hover:scale-110 transition">
                                    <img src="{{ asset('images/icons/excel.svg') }}" alt="Microsoft Excel"
                                        class="w-12 h-12 md:w-16 md:h-16 drop-shadow-2xl">
                                </div>
                            </div>

                            {{-- PowerPoint Icon (Left) --}}
                            <div class="absolute -left-24 top-20 md:-left-40 md:top-24 animate-float"
                                style="animation-delay: 1s;">
                                <div class="transform hover:scale-110 transition">
                                    <img src="{{ asset('images/icons/emagic.svg') }}" alt="Emagic System"
                                        class="w-12 h-12 md:w-16 md:h-16 drop-shadow-2xl">
                                </div>
                            </div>

                            {{-- Outlook Icon (Right) --}}
                            <div class="absolute -right-24 top-36 md:-right-40 md:top-20 animate-float"
                                style="animation-delay: 1.5s;">
                                <div class="transform hover:scale-110 transition">
                                    <img src="{{ asset('images/icons/outlook.svg') }}" alt="Microsoft Outlook"
                                        class="w-12 h-12 md:w-16 md:h-16 drop-shadow-2xl">
                                </div>
                            </div>

                            {{-- Teams Icon (Bottom Left) --}}
                            <div class="absolute -left-16 top-56 bottom-0 md:-left-28 md:-bottom-8 animate-float"
                                style="animation-delay: 2s;">
                                <div class="transform hover:scale-110 transition">
                                    <img src="{{ asset('images/icons/xamtlogo.svg') }}" alt="Xamt system"
                                        class="w-12 h-12 md:w-16 md:h-16 drop-shadow-2xl">
                                </div>
                            </div>

                            {{-- OneDrive Icon (Bottom Right) --}}
                            <div class="absolute -right-16 top-56 -bottom-4 md:-right-28 md:-bottom-12 animate-float"
                                style="animation-delay: 2.5s;">
                                <div class="transform hover:scale-110 transition">
                                    <img src="{{ asset('images/icons/sharepoint.svg') }}" alt="Microsoft SharePoint"
                                        class="w-12 h-12 md:w-16 md:h-16 drop-shadow-2xl">
                                </div>
                            </div>
                        </div>

                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">
                            {{ __('frontend.slogan1') }}
                            <br>
                            <span class="bg-gradient-to-r from-green-200 to-emerald-200 bg-clip-text text-transparent">
                                {{ __('frontend.slogan2') }}
                            </span>
                        </h1>
                    </div>

                    {{-- Subtitle --}}
                    <p class="text-xl md:text-2xl text-green-100 mb-12 max-w-3xl mx-auto">
                        {{ __('frontend.slogan3') }}
                    </p>

                    {{-- CTAs --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ localized_route('contact.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-600 rounded-xl font-bold text-lg hover:bg-green-50 transition transform hover:scale-105 shadow-xl">
                            {{ __('frontend.get_started') }}
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ localized_route('services.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-bold text-lg hover:bg-white/20 transition border-2 border-white/20">
                            {{ __('frontend.view_services') }}
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-white mb-2">2000+</div>
                            <div class="text-green-200">{{ __('frontend.customers') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-white mb-2">98%</div>
                            <div class="text-green-200">{{ __('frontend.satisfaction') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-white mb-2">24/7</div>
                            <div class="text-green-200">{{ __('frontend.support') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-white mb-2">10+</div>
                            <div class="text-green-200">{{ __('frontend.years') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Wave Divider --}}
            <div class="absolute bottom-0 left-0 right-0 ">
                <svg viewBox="0 0 1440 119" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                        fill="white" />
                </svg>
            </div>
        </section>
    @endif

    <section class="py-10 bg-white relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-0 w-96 h-96 bg-green-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-500 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 lg:gap-8">
                @php
                    $steps = [
                        [
                            'icon' =>
                                'M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5',
                            'title' => __('frontend.code_sending'),
                            'link' => 'https://magicfinance.hamt.mn/code.php/code/codec',
                        ],
                        [
                            'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                            'title' => __('frontend.software_help'),
                            'link' => 'https://www.magicgroup.mn/mn/help',
                        ],
                        [
                            'number' => '04',
                            'icon' =>
                                'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5',
                            'title' => __('frontend.submit_traning'),
                            'link' => 'https://www.magicgroup.mn/mn/magicchoice/1/188/m/surgalt_burtgel.html',
                        ],
                        [
                            'icon' =>
                                'M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75',
                            'title' => __('frontend.request_quote_audit'),
                            'link' => 'https://www.magicgroup.mn/auditpricerequest.php',
                        ],
                        [
                            'icon' =>
                                'm20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z',
                            'title' => __('frontend.request_quote_tmz'),
                            'link' => 'https://www.magicgroup.mn/auditpricerequest.php',
                        ],
                    ];
                @endphp

                @foreach ($steps as $index => $step)
                    <div class="relative group">
                        <div
                            class="relative text-center bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-300 transform hover:-translate-y-2 z-10">
                            {{-- Number Badge --}}
                            <div class="relative inline-flex items-center justify-center mb-4">
                                <div
                                    class="absolute w-20 h-20 bg-green-100 rounded-full group-hover:scale-125 transition-transform duration-500">
                                </div>
                                <div
                                    class="relative w-16 h-16 bg-gradient-to-br from-green-600 to-emerald-700 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg group-hover:shadow-2xl group-hover:scale-110 transition-all duration-300">
                                    <a href="{{ $step['link'] }}" target="_blank">
                                        <svg class="w-10 h-10 mx-auto text-white group-hover:text-white transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $step['icon'] }}" />
                                        </svg>
                                    </a>
                                </div>
                            </div>


                            <a href="{{ $step['link'] }}" target="_blank">
                                <h3 class="text-lg text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                    {{ $step['title'] }}</h3>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- Latest Posts / Blog Section --}}
    @if ($latestPosts->count() > 0)
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">
                            {{ __('frontend.latest_insights') }}
                        </h2>
                        <p class="text-xl text-gray-600">{{ __('frontend.latest_insights_subtitle') }}</p>
                    </div>
                    <a href="{{ localized_route('posts.index') }}"
                        class="hidden md:inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition">
                        {{ __('frontend.view_all') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                {{-- Posts Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($latestPosts->take(3) as $post)
                        <article
                            class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300">
                            @if ($post->featuredImage)
                                <div class="relative h-56 overflow-hidden">
                                    <img src="{{ $post->featuredImage->url }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                </div>
                            @endif

                            <div class="p-6">
                                {{-- Meta --}}
                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $post->published_at->format('M d, Y') }}
                                    </span>
                                    @if ($post->category)
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                            {{ $post->category->title }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition line-clamp-2">
                                    <a
                                        href="{{ route('posts.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                {{-- Excerpt --}}
                                @if ($post->excerpt)
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                @endif

                                {{-- Read More --}}
                                <a href="{{ route('posts.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}"
                                    class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition">
                                    {{ __('frontend.read_more') }}
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif



    {{-- Testimonials Section --}}
    @if ($testimonials->count() > 0)
        @include('frontend.partials.testimonials-section')
    @endif
    {{-- Clients Section --}}
    @if ($clients->count() > 0)
        @include('frontend.partials.clients-section')
    @endif

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-green-600 to-emerald-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                {{ __('frontend.ready_to_get_started') }}
            </h2>
            <p class="text-xl text-green-100 mb-10">
                {{ __('frontend.ready_to_get_started_desc') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ localized_route('contact.index') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-600 rounded-xl font-bold text-lg hover:bg-green-50 transition transform hover:scale-105 shadow-xl">
                    {{ __('frontend.contact_us_now') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </a>
                <a href="{{ localized_route('services.index') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-bold text-lg hover:bg-white/20 transition border-2 border-white/20">
                    {{ __('frontend.explore_services') }}
                </a>
            </div>
        </div>
    </section>
@endsection
