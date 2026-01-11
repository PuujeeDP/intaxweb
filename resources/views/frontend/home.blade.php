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
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-red-900/70 via-red-800/50 to-transparent">
                                </div>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-gray-100">
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
                            <div class="max-w-3xl text-white">
                                @if ($slider->button_text)
                                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
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
                                            class="inline-flex items-center justify-center px-8 py-4 text-white rounded-xl font-bold text-lg transition transform hover:scale-105"
                                            style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%);"
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
        <section class="relative min-h-[90vh] flex items-center overflow-hidden"
            style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #f1f3f5 100%);">
            {{-- Background decorations --}}
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 right-0 bottom-0"
                    style="background: radial-gradient(circle at 20% 50%, rgba(212, 12, 25, 0.05) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(212, 12, 25, 0.03) 0%, transparent 40%);">
                </div>
            </div>

            {{-- Hexagon decoration --}}
            <div class="hero-hexagon hidden lg:block">
                <svg viewBox="0 0 100 100" fill="none">
                    <polygon points="50,5 95,27.5 95,72.5 50,95 5,72.5 5,27.5" stroke="#d40c19" stroke-width="0.5"
                        fill="none" opacity="0.2" />
                    <polygon points="50,15 85,32.5 85,67.5 50,85 15,67.5 15,32.5" stroke="#d40c19" stroke-width="0.3"
                        fill="none" opacity="0.15" />
                    <polygon points="50,25 75,37.5 75,62.5 50,75 25,62.5 25,37.5" stroke="#d40c19" stroke-width="0.2"
                        fill="none" opacity="0.1" />
                </svg>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    {{-- Hero Text --}}
                    <div class="text-center lg:text-left">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold text-gray-900 mb-6 leading-tight animate-fade-in-up"
                            style="font-family: 'Open Sans', sans-serif;">
                            Монгол дахь <span class="text-[#d40c19]">татвар, санхүү, хуулийн</span> мэргэжлийн зөвлөгөө
                        </h1>
                        <p class="text-lg text-gray-600 mb-10 max-w-xl mx-auto lg:mx-0 animate-fade-in-up"
                            style="animation-delay: 0.2s;">
                            Гадаадын хөрөнгө оруулагч болон бизнес эрхлэгчдэд зориулсан иж бүрэн татвар, санхүү, хууль зүйн
                            зөвлөгөө үйлчилгээ. Бид таны бизнесийг Монголд амжилттай явуулахад туслана.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-in-up"
                            style="animation-delay: 0.4s;">

                            <a href="{{ localized_route('services.index') }}"
                                class="inline-flex items-center justify-center px-8 py-4 text-white font-semibold rounded-md transition-all duration-300 hover:-translate-y-0.5"
                                style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%); box-shadow: 0 4px 15px rgba(212, 12, 25, 0.3);">
                                {{ __('frontend.view_services') }}
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    @endif




    {{-- Services Section --}}
    @if (isset($services) && $services->count() > 0)
        <section class="py-20 lg:py-28 bg-white relative" id="services">
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-gray-50 to-transparent"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-5"
                        style="font-family: 'Open Sans', sans-serif;">
                        {{ __('frontend.our_services') ?? 'Бидний үзүүлэх үйлчилгээнүүд' }}
                    </h2>

                </div>

                {{-- Services Grid --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($services as $service)
                        <a href="{{ route('services.show', ['locale' => app()->getLocale(), 'slug' => $service->slug]) }}"
                            class="service-card animate-on-scroll relative bg-white p-8 rounded-2xl text-center transition-all duration-300 border border-gray-100 hover:-translate-y-2 hover:shadow-xl hover:border-transparent overflow-hidden group">
                            <div class="w-[75px] h-[75px] mx-auto mb-5 rounded-full flex items-center justify-center text-3xl transition-all duration-300 group-hover:scale-110"
                                style="background: linear-gradient(135deg, rgba(227, 27, 35, 0.08) 0%, rgba(227, 27, 35, 0.15) 100%);">
                                <span
                                    class="group-hover:brightness-0 group-hover:invert transition-all">{{ $service->icon ?? '📋' }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3"
                                style="font-family: 'Open Sans', sans-serif;">
                                {{ $service->title }}
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">{{ $service->description }}</p>
                        </a>
                    @endforeach
                </div>

                {{-- View All Services Button --}}
                <div class="text-center mt-12">
                    <a href="{{ localized_route('services.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 text-white font-semibold rounded-md transition-all duration-300 hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%); box-shadow: 0 4px 15px rgba(212, 12, 25, 0.3);">
                        {{ __('frontend.view_all_services') ?? 'Бүх үйлчилгээг үзэх' }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Clients Section --}}
    @if (isset($clients) && $clients->count() > 0)
        @include('frontend.partials.clients-section')
    @endif





    {{-- Latest Posts Section --}}
    @if (isset($latestPosts) && $latestPosts->count() > 0)
        <section class="py-20 lg:py-28 bg-white" id="latest-posts">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
                    <div>
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900"
                            style="font-family: 'Open Sans', sans-serif;">
                            {{ __('frontend.latest_insights') }}
                        </h2>
                    </div>
                    <a href="{{ localized_route('posts.index') }}"
                        class="hidden md:inline-flex items-center text-[#d40c19] font-semibold hover:underline mt-4 md:mt-0">
                        {{ __('frontend.view_all') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                {{-- Two Column Layout --}}
                <div class="grid lg:grid-cols-2 gap-8">
                    {{-- Left Column: Featured Post (Large) --}}
                    @if ($latestPosts->first())
                        @php $featuredPost = $latestPosts->first(); @endphp
                        <article
                            class="animate-on-scroll group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                            @if ($featuredPost->featuredImage)
                                <div class="relative h-72 lg:h-80 overflow-hidden">
                                    <img src="{{ $featuredPost->featuredImage->url }}" alt="{{ $featuredPost->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                                    </div>
                                    @if ($featuredPost->category)
                                        <span
                                            class="absolute top-4 left-4 px-3 py-1 bg-[#d40c19] text-white rounded-full text-xs font-medium">
                                            {{ $featuredPost->category->title }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="p-6 lg:p-8">
                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $featuredPost->published_at->format('M d, Y') }}
                                    </span>
                                </div>

                                <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 group-hover:text-[#d40c19] transition line-clamp-2"
                                    style="font-family: 'Open Sans', sans-serif;">
                                    <a
                                        href="{{ route('posts.show', ['locale' => app()->getLocale(), 'slug' => $featuredPost->slug]) }}">
                                        {{ $featuredPost->title }}
                                    </a>
                                </h3>

                                @if ($featuredPost->excerpt)
                                    <p class="text-gray-600 mb-6 line-clamp-3 text-base leading-relaxed">
                                        {{ $featuredPost->excerpt }}</p>
                                @endif

                                <a href="{{ route('posts.show', ['locale' => app()->getLocale(), 'slug' => $featuredPost->slug]) }}"
                                    class="inline-flex items-center text-[#d40c19] font-semibold hover:underline">
                                    {{ __('frontend.read_more') }}
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endif

                    {{-- Right Column: List of 9 Posts --}}
                    <div class="space-y-4">
                        @foreach ($latestPosts->skip(1)->take(9) as $post)
                            <article
                                class="animate-on-scroll group flex gap-4 p-4 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-100">
                                @if ($post->featuredImage)
                                    <div class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 rounded-lg overflow-hidden">
                                        <img src="{{ $post->featuredImage->url }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </div>
                                @else
                                    <div
                                        class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-2">
                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                        @if ($post->category)
                                            <span
                                                class="px-2 py-0.5 bg-red-100 text-[#d40c19] rounded text-xs font-medium">
                                                {{ $post->category->title }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3
                                        class="text-base font-bold text-gray-900 group-hover:text-[#d40c19] transition line-clamp-2 mb-1">
                                        <a
                                            href="{{ route('posts.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    @if ($post->excerpt)
                                        <p class="text-gray-500 text-sm line-clamp-1 hidden sm:block">{{ $post->excerpt }}
                                        </p>
                                    @endif

                                    <a href="{{ route('posts.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}"
                                        class="inline-flex items-center text-[#d40c19] text-sm font-medium hover:underline mt-2">
                                        {{ __('frontend.read_more') }}
                                        <svg class="w-3 h-3 ml-1 group-hover:translate-x-1 transition" fill="none"
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

                {{-- Mobile View All Button --}}
                <div class="text-center mt-10 md:hidden">
                    <a href="{{ localized_route('posts.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 text-[#d40c19] font-semibold border-2 border-[#d40c19] rounded-lg hover:bg-[#d40c19] hover:text-white transition-all duration-300">
                        {{ __('frontend.view_all') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials Section --}}
    @if (isset($testimonials) && $testimonials->count() > 0)
        @include('frontend.partials.testimonials-section')
    @endif



@endsection
