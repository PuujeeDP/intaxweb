@extends('frontend.layouts.app')

@php
    $metaTitle = $category->name . ' | ' . config('app.name');
    $metaDescription = 'Browse posts in ' . $category->name . ' category';
@endphp

@section('content')
    {{-- Hero Section - Same as posts/index --}}
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 50%, #7a0810 100%);">
        {{-- Hexagon Pattern Background --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hexagon-pattern-category" x="0" y="0" width="56" height="100"
                        patternUnits="userSpaceOnUse">
                        <polygon points="28,6 52,18 52,42 28,54 4,42 4,18" fill="none" stroke="white" stroke-width="0.5"
                            opacity="0.6" />
                        <polygon points="28,56 52,68 52,92 28,104 4,92 4,68" fill="none" stroke="white"
                            stroke-width="0.5" opacity="0.6" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hexagon-pattern-category)" />
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
                    {{ $category->name }}
                </h1>
            </div>
        </div>
    </section>

    {{-- Main Content with Sidebar --}}
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Posts List (Main Content) --}}
                <div class="lg:col-span-2">
                    @if ($posts->count() > 0)
                        <div class="space-y-8">
                            @foreach ($posts as $index => $post)
                                <article
                                    class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-[#d40c19]/30">

                                    <div class="flex flex-col md:flex-row">
                                        {{-- Featured Image --}}
                                        <a href="{{ localized_route('posts.show', ['slug' => $post->slug]) }}"
                                            class="block md:w-72 lg:w-80 flex-shrink-0 relative overflow-hidden">
                                            @if ($post->featuredImage)
                                                <div class="h-56 md:h-full min-h-[200px] overflow-hidden bg-gray-100">
                                                    <img src="{{ $post->featuredImage->url }}" alt="{{ $post->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                </div>
                                            @else
                                                <div
                                                    class="h-56 md:h-full min-h-[200px] bg-gradient-to-br from-[#d40c19] to-[#a00a14] flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-white/50" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                    </svg>
                                                </div>
                                            @endif

                                            {{-- Category Badge --}}
                                            @if ($post->category)
                                                <div class="absolute top-4 left-4">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full bg-[#d40c19] text-white text-xs font-bold shadow-lg">
                                                        {{ $post->category->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </a>

                                        {{-- Content --}}
                                        <div class="flex-1 p-6 flex flex-col justify-between">
                                            {{-- Meta Info --}}
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-3">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5 text-[#d40c19]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <time datetime="{{ $post->published_at?->format('Y-m-d') }}">
                                                        {{ $post->published_at?->format('Y.m.d') }}
                                                    </time>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5 text-[#d40c19]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <span>{{ $post->author->name }}</span>
                                                </div>
                                            </div>

                                            {{-- Title --}}
                                            <h2
                                                class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#d40c19] transition-colors duration-300">
                                                <a href="{{ localized_route('posts.show', ['slug' => $post->slug]) }}">
                                                    {{ $post->title }}
                                                </a>
                                            </h2>

                                            {{-- Excerpt --}}
                                            @if ($post->excerpt)
                                                <p class="text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                                                    {{ Str::limit($post->excerpt, 180) }}
                                                </p>
                                            @endif

                                            {{-- Read More Link --}}
                                            <div class="mt-auto">
                                                <a href="{{ localized_route('posts.show', ['slug' => $post->slug]) }}"
                                                    class="inline-flex items-center text-[#d40c19] hover:text-[#a00a14] font-semibold group/link">
                                                    {{ __('frontend.read_more') }}
                                                    <svg class="w-5 h-5 ml-2 transform group-hover/link:translate-x-1 transition-transform"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-12">
                            {{ $posts->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-20 bg-white rounded-2xl shadow-md">
                            <div
                                class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-red-100 to-red-200 rounded-full mb-6">
                                <svg class="w-12 h-12 text-[#d40c19]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('frontend.no_posts_found') }}</h3>
                            <p class="text-lg text-gray-600 mb-8">{{ __('frontend.check_back_later') }}</p>
                            <a href="{{ localized_route('posts.index') }}"
                                class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-lg transition-all duration-300 hover:-translate-y-0.5"
                                style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
                                {{ __('frontend.view_all_posts') }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">

                        {{-- Search Box --}}
                        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-[#d40c19] mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('frontend.search') }}
                            </h3>
                            <form action="{{ localized_route('posts.index') }}" method="GET">
                                <div class="relative">
                                    <input type="text" name="search" value=""
                                        placeholder="{{ __('frontend.search_placeholder') }}"
                                        class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-200 focus:border-[#d40c19] focus:ring-2 focus:ring-[#d40c19]/20 transition-all">
                                    <button type="submit"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-[#d40c19] transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Current Category --}}
                        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-[#d40c19] mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ __('frontend.category') }}
                            </h3>
                            <div class="inline-flex items-center px-4 py-2 rounded-lg bg-[#d40c19] text-white font-semibold">
                                {{ $category->name }}
                            </div>
                        </div>

                        {{-- Back to All Posts --}}
                        <a href="{{ localized_route('posts.index') }}"
                            class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('frontend.back_to_posts') }}
                        </a>

                    </div>
                </aside>

            </div>
        </div>
    </section>
@endsection
