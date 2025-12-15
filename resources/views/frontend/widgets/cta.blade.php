{{-- CTA Widget --}}
<div class="widget widget-cta mb-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg p-6 text-center" data-widget-key="{{ $widget->key }}">
    @if(!empty($widget->content['title']))
        <h3 class="text-2xl font-bold mb-3">{{ $widget->content['title'] }}</h3>
    @endif

    @if(!empty($widget->content['description']))
        <p class="text-white/90 mb-4">{{ $widget->content['description'] }}</p>
    @endif

    @if(!empty($widget->content['button_text']) && !empty($widget->content['button_url']))
        <a href="{{ $widget->content['button_url'] }}"
           class="inline-block bg-white text-green-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors">
            {{ $widget->content['button_text'] }}
        </a>
    @endif
</div>
