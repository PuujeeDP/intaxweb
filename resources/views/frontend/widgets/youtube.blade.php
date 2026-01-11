{{-- YouTube Widget --}}
<div class="widget widget-youtube mb-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden" data-widget-key="{{ $widget->key }}">
    @if (!empty($widget->content['title']))
        <div class="p-5 border-b border-gray-100" style="background: linear-gradient(135deg, #d40c19 0%, #a00a14 100%);">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                </svg>
                {{ $widget->content['title'] }}
            </h3>
        </div>
    @endif

    <div class="aspect-video w-full">
        @php
            $videoUrl = $widget->content['video_url'] ?? '';
            $videoId = '';

            // Extract video ID from various YouTube URL formats
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches)) {
                $videoId = $matches[1];
            }
        @endphp

        @if ($videoId)
            <iframe
                src="https://www.youtube.com/embed/{{ $videoId }}"
                class="w-full h-full"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
            </iframe>
        @elseif (!empty($widget->content['embed_code']))
            <div class="w-full h-full [&_iframe]:w-full [&_iframe]:h-full">
                {!! $widget->content['embed_code'] !!}
            </div>
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                </svg>
            </div>
        @endif
    </div>
</div>
