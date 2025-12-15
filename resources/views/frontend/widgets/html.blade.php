{{-- HTML Widget --}}
<div class="widget widget-html mb-6" data-widget-key="{{ $widget->key }}">
    <div class="prose prose-sm md:prose-base max-w-none">
        {!! $widget->content['html'] ?? '' !!}
    </div>
</div>
