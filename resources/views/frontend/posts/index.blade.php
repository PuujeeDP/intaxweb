@extends('frontend.layouts.app')

@php
    $metaTitle =
        __('frontend.blog_posts') .
        ($search ? ' - ' . __('frontend.search') . ': ' . $search : '') .
        ' | ' .
        config('app.name');
    $metaDescription = __('frontend.discover_articles') . ($search ? ' ' . $search : '');
@endphp

@section('content')
    {{-- Modern Hero Section --}}
    <section class="relative bg-gradient-to-br from-green-600 via-green-700 to-emerald-900 overflow-hidden">
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="posts-grid" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                        <circle cx="30" cy="30" r="1.5" fill="white" opacity="0.6" />
                        <line x1="30" y1="30" x2="60" y2="30" stroke="white" stroke-width="0.5" opacity="0.4" />
                        <line x1="30" y1="30" x2="30" y2="60" stroke="white" stroke-width="0.5" opacity="0.4" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#posts-grid)" />
            </svg>
        </div>

        {{-- Floating Gradient Orbs --}}
        <div class="absolute inset-0 overflow-hidden opacity-20">
            <div class="absolute -top-1/4 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-300 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                {{-- Badge --}}
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full mb-8 border border-white/20">
                    <svg class="w-5 h-5 text-green-200 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="text-sm font-semibold text-white">
                        @if ($search)
                            {{ __('frontend.search_results') }}
                        @else
                            {{ __('frontend.insights_articles') }}
                        @endif
                    </span>
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">
                    @if ($search)
                        {{ __('frontend.search_results_for') }} <br>
                        <span class="bg-gradient-to-r from-green-200 to-emerald-200 bg-clip-text text-transparent">"{{ $search }}"</span>
                    @else
                        {{ __('frontend.blog_posts') }}
                    @endif
                </h1>

                <p class="text-xl md:text-2xl text-green-100 max-w-3xl mx-auto leading-relaxed">
                    @if ($search)
                        {{ __('frontend.posts_found', ['count' => $posts->total()]) }}
                    @else
                        {{ __('frontend.discover_articles') }}
                    @endif
                </p>
            </div>
        </div>
    </section>

    {{-- Categories Filter Section --}}
    @if($categories->count() > 0)
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg font-bold text-gray-900 flex items-center mb-4">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                {{ __('frontend.categories') }}
            </h2>

            <div class="flex flex-wrap gap-3">
                @foreach($categories as $category)
                    <a href="{{ localized_route('categories.show', ['slug' => $category->slug]) }}"
                        class="group inline-flex items-center px-4 py-2 rounded-lg bg-gray-50 hover:bg-green-600 text-gray-700 hover:text-white border border-gray-200 hover:border-green-600 transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                        <span class="font-medium">{{ $category->name }}</span>
                        @if($category->posts_count > 0)
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-white/80 group-hover:bg-white/90 text-gray-700 font-semibold">
                                {{ $category->posts_count }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Posts Grid Section --}}
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($posts as $index => $post)
                        <article
                            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-green-300 transform hover:-translate-y-2"
                            data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">

                            {{-- Featured Image --}}
                            <a href="{{ localized_route('posts.show', ['slug' => $post->slug]) }}" class="block relative overflow-hidden">
                                @if ($post->featuredImage)
                                    <div class="h-56 overflow-hidden bg-gray-100">
                                        <img src="{{ $post->featuredImage->url }}"
                                            alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        {{-- Overlay --}}
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    </div>
                                @else
                                    <div class="h-56 bg-gradient-to-br from-green-500 to-emerald-700 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Category Badge on Image --}}
                                @if ($post->category)
                                    <div class="absolute top-4 left-4">
                                        <a href="{{ localized_route('categories.show', ['slug' => $post->category->slug]) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white/95 backdrop-blur-sm text-green-700 text-xs font-bold shadow-lg hover:bg-green-600 hover:text-white transition-colors duration-300">
                                            {{ $post->category->name }}
                                        </a>
                                    </div>
                                @endif
                            </a>

                            <div class="p-6">
                                {{-- Title --}}
                                <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors duration-300">
                                    <a href="{{ localized_route('posts.show', ['slug' => $post->slug]) }}">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                {{-- Excerpt --}}
                                @if ($post->excerpt)
                                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($post->excerpt, 150) }}
                                    </p>
                                @endif

                                {{-- Meta Info --}}
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="font-medium text-gray-700">{{ $post->author->name }}</span>
                                    </div>
                                    <time datetime="{{ $post->published_at?->format('Y-m-d') }}" class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $post->published_at?->format('M d, Y') }}
                                    </time>
                                </div>

                                {{-- Read More Link --}}
                                <a href="{{ localized_route('posts.show', ['slug' => $post->slug]) }}"
                                    class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold group/link">
                                    {{ __('frontend.read_more') }}
                                    <svg class="w-5 h-5 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Modern Pagination --}}
                <div class="flex justify-center">
                    {{ $posts->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full mb-6">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('frontend.no_posts_found') }}</h3>
                    <p class="text-lg text-gray-600 mb-8">
                        @if ($search)
                            {{ __('frontend.try_different_keywords') }}
                        @else
                            {{ __('frontend.check_back_later') }}
                        @endif
                    </p>
                    @if ($search)
                        <a href="{{ localized_route('posts.index') }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl font-bold text-lg hover:from-green-700 hover:to-emerald-800 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                            {{ __('frontend.view_all_posts') }}
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
