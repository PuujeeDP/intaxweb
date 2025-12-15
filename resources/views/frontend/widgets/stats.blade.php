{{-- Stats Widget --}}
<div class="widget widget-stats mb-6" data-widget-key="{{ $widget->key }}">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @for($i = 1; $i <= 4; $i++)
            @if(!empty($widget->content["stat{$i}_number"]))
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600 mb-1">
                        {{ $widget->content["stat{$i}_number"] }}
                    </div>
                    @if(!empty($widget->content["stat{$i}_label"]))
                        <div class="text-sm text-gray-600">
                            {{ $widget->content["stat{$i}_label"] }}
                        </div>
                    @endif
                </div>
            @endif
        @endfor
    </div>
</div>
