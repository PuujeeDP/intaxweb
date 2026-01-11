{{-- Sidebar --}}
<div class="space-y-6">
    {{-- Dynamic Widgets Area --}}
    @php
        $widgetsHtml = render_widgets_area('sidebar');
    @endphp

    @if (!empty(trim($widgetsHtml)))
        {!! $widgetsHtml !!}
    @endif

    {{-- Latest Posts Widget --}}
    @php
        $latestPosts = \App\Models\Post::published()
            ->with(['featuredImage', 'category'])
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
    @endphp

    @if ($latestPosts->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100"
                style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    {{ __('frontend.latest_posts') }}
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach ($latestPosts as $post)
                    <a href="{{ localized_route('posts.show', ['slug' => $post->slug]) }}"
                        class="flex items-start p-4 hover:bg-gray-50 transition group">
                        @if ($post->featuredImage)
                            <img src="{{ $post->featuredImage->url }}" alt="{{ $post->title }}"
                                class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                        @else
                            <div class="w-16 h-16 rounded-lg flex-shrink-0 flex items-center justify-center"
                                style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
                                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="ml-3 flex-1 min-w-0">
                            <h4
                                class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-[#d40c19] transition">
                                {{ $post->title }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $post->published_at?->format('M d, Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif



    {{-- Contact CTA Widget --}}
    <div class="rounded-2xl shadow-lg overflow-hidden"
        style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
        <div class="p-6 text-center">
            <div class="w-14 h-14 mx-auto mb-4 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.need_help') }}</h3>
            <p class="text-red-100 text-sm mb-4">{{ __('frontend.contact_us_anytime') }}</p>
            <a href="{{ localized_route('contact.index') }}"
                class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-white text-[#d40c19] rounded-xl font-semibold text-sm hover:bg-red-50 transition">
                {{ __('frontend.contact_us') }}
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>
