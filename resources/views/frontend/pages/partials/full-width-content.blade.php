{{-- Full Width Content (No Sidebar) --}}

{{-- Featured Image --}}
@if ($page->featuredImage)
    <div class="mb-8 animate-fade-in-up">
        <img src="{{ asset('storage/' . $page->featuredImage->file_path) }}"
             alt="{{ $title }}"
             class="w-full h-auto shadow-2xl">
    </div>
@endif

{{-- Main Content --}}
<div class="animate-fade-in-up" style="animation-delay: 0.3s;">
    <div class="prose prose-lg max-w-none
                prose-headings:font-bold prose-headings:text-gray-900
                prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-6
                prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4
                prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-6
                prose-a:text-[#d40c19] prose-a:font-medium hover:prose-a:text-[#a00a14]
                prose-strong:text-gray-900 prose-strong:font-bold
                prose-ul:list-disc prose-ul:ml-6 prose-ul:my-6 prose-ul:space-y-2 prose-ul:marker:text-[#d40c19]
                prose-ol:list-decimal prose-ol:ml-6 prose-ol:my-6 prose-ol:space-y-2 prose-ol:marker:text-[#d40c19]
                prose-li:my-2 prose-li:text-gray-700 prose-li:pl-2
                prose-img:shadow-xl
                prose-blockquote:border-l-4 prose-blockquote:border-[#d40c19] prose-blockquote:pl-4 prose-blockquote:italic
                prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded
                [&_iframe]:w-full [&_iframe]:aspect-video [&_iframe]:rounded-xl
                [&>*]:mb-4 [&>p]:mb-6">
        {!! $content !!}
    </div>
</div>

{{-- Page Sections --}}
@include('frontend.pages.partials.page-sections')

{{-- Share Buttons --}}
@include('frontend.pages.partials.share-buttons')
