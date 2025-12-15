{{-- Contact Widget --}}
<div class="widget widget-contact mb-6 bg-white border rounded-lg p-4" data-widget-key="{{ $widget->key }}">
    <h4 class="font-semibold text-gray-900 mb-3">Contact Information</h4>
    <div class="space-y-2 text-sm">
        @if(!empty($widget->content['email']))
            <div class="flex items-center text-gray-600">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <a href="mailto:{{ $widget->content['email'] }}" class="hover:text-green-600">
                    {{ $widget->content['email'] }}
                </a>
            </div>
        @endif

        @if(!empty($widget->content['phone']))
            <div class="flex items-center text-gray-600">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <a href="tel:{{ $widget->content['phone'] }}" class="hover:text-green-600">
                    {{ $widget->content['phone'] }}
                </a>
            </div>
        @endif

        @if(!empty($widget->content['address']))
            <div class="flex items-start text-gray-600">
                <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ $widget->content['address'] }}</span>
            </div>
        @endif
    </div>
</div>
