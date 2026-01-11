@extends('frontend.layouts.app')

@php
    $metaTitle = $post->meta_title ?? $post->title;
    $metaDescription = $post->meta_description ?? $post->excerpt;
    $ogImage = $post->featuredImage ? $post->featuredImage->url : null;
@endphp

@section('content')
    {{-- Hero Section - Same as posts/index --}}
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 50%, #7a0810 100%);">
        {{-- Hexagon Pattern Background --}}
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hexagon-pattern-post" x="0" y="0" width="56" height="100"
                        patternUnits="userSpaceOnUse">
                        <polygon points="28,6 52,18 52,42 28,54 4,42 4,18" fill="none" stroke="white"
                            stroke-width="0.5" opacity="0.6" />
                        <polygon points="28,56 52,68 52,92 28,104 4,92 4,68" fill="none" stroke="white"
                            stroke-width="0.5" opacity="0.6" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hexagon-pattern-post)" />
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
                    {{ $post->title }}
                </h1>
            </div>
        </div>
    </section>

    {{-- Main Content with Sidebar --}}
    <section class="py-12 lg:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Article Content --}}
                <article class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-md p-6 lg:p-10 border border-gray-100">
                        {{-- Featured Image --}}
                        @if ($post->featuredImage)
                            <div class="mb-8">
                                <div class="rounded-xl overflow-hidden">
                                    <img src="{{ $post->featuredImage->url }}" alt="{{ $post->title }}"
                                        class="w-full h-auto">
                                </div>
                            </div>
                        @endif

                        {{-- Excerpt --}}
                        @if ($post->excerpt)
                            <p class="text-lg text-gray-600 mb-8 leading-relaxed border-l-4 border-[#d40c19] pl-4 italic">
                                {{ $post->excerpt }}
                            </p>
                        @endif

                        {{-- Content --}}
                        <div
                            class="prose prose-lg max-w-none
                            prose-headings:font-bold prose-headings:text-gray-900
                            prose-h2:text-2xl prose-h2:mb-4 prose-h2:mt-8
                            prose-h3:text-xl prose-h3:mb-3 prose-h3:mt-6
                            prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-5
                            prose-a:text-[#d40c19] prose-a:no-underline hover:prose-a:text-[#a00a14] hover:prose-a:underline
                            prose-strong:text-gray-900 prose-strong:font-semibold
                            prose-ul:list-disc prose-ul:pl-6 prose-ul:mb-5
                            prose-ol:list-decimal prose-ol:pl-6 prose-ol:mb-5
                            prose-li:text-gray-700 prose-li:mb-1
                            prose-img:rounded-xl prose-img:shadow-lg
                            prose-blockquote:border-l-4 prose-blockquote:border-[#d40c19] prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-600
                            prose-code:text-[#d40c19] prose-code:bg-red-50 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded">
                            {!! $post->content !!}
                        </div>


                    </div>
                </article>

                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">

                        {{-- Categories --}}
                        @if ($post->category)
                            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-[#d40c19] mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    {{ __('frontend.category') }}
                                </h3>
                                <a href="{{ localized_route('categories.show', ['slug' => $post->category->slug]) }}"
                                    class="inline-flex items-center px-4 py-2 rounded-lg bg-[#d40c19]/10 text-[#d40c19] hover:bg-[#d40c19] hover:text-white font-semibold transition-all">
                                    {{ $post->category->name }}
                                </a>
                            </div>
                        @endif

                        {{-- Related Posts --}}
                        @if ($relatedPosts->count() > 0)
                            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-[#d40c19] mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    {{ __('frontend.related_posts') }}
                                </h3>
                                <ul class="space-y-4">
                                    @foreach ($relatedPosts->take(5) as $relatedPost)
                                        <li>
                                            <a href="{{ localized_route('posts.show', ['slug' => $relatedPost->slug]) }}"
                                                class="flex items-start gap-3 group">
                                                @if ($relatedPost->featuredImage)
                                                    <img src="{{ $relatedPost->featuredImage->url }}"
                                                        alt="{{ $relatedPost->title }}"
                                                        class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                                @else
                                                    <div
                                                        class="w-16 h-16 rounded-lg bg-gradient-to-br from-[#d40c19]/10 to-[#d40c19]/20 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-[#d40c19]/50" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <h4
                                                        class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-[#d40c19] transition-colors">
                                                        {{ $relatedPost->title }}
                                                    </h4>
                                                    <time
                                                        class="text-xs text-gray-500 mt-1 block">{{ $relatedPost->published_at?->format('Y.m.d') }}</time>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Back to Posts --}}
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
