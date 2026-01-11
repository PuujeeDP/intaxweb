@if ($page->sections && $page->sections->count() > 0)
    @php
        $sectionType = $page->sections->first()->type ?? 'tab';
    @endphp

    @if ($sectionType === 'tab')
        {{-- Tab Layout - Line Triangle Style --}}
        <div x-data="{ activeTab: 0 }" class="mt-12 animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="flex flex-wrap gap-2 mb-8 border-b-2 border-gray-200">
                @foreach ($page->sections as $index => $section)
                    <button @click="activeTab = {{ $index }}"
                        class="relative px-6 py-4 font-semibold transition-all duration-300 whitespace-nowrap"
                        :class="activeTab === {{ $index }} ?
                            'text-red-600' :
                            'text-gray-600 hover:text-red-600'">
                        <span class="flex items-center space-x-2">
                            @if ($section->icon)
                                <span>{!! $section->icon !!}</span>
                            @endif
                            <span>{{ $section->translate('title', $locale) ?? $section->title }}</span>
                        </span>
                        {{-- Active indicator: line + triangle --}}
                        <span x-show="activeTab === {{ $index }}"
                            class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-x-0"
                            x-transition:enter-end="opacity-100 scale-x-100"></span>
                        <span x-show="activeTab === {{ $index }}"
                            class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-0 h-0 border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-t-[8px] border-t-red-600"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"></span>
                    </button>
                @endforeach
            </div>

            @foreach ($page->sections as $index => $section)
                <div x-show="activeTab === {{ $index }}" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0" class="py-6">
                    <div
                        class="prose prose-lg max-w-none
                                prose-headings:text-gray-900
                                prose-p:text-gray-700 prose-p:leading-relaxed
                                prose-a:text-red-600 hover:prose-a:text-red-700
                                prose-ul:list-disc prose-ul:ml-6 prose-ul:space-y-2 prose-ul:marker:text-red-600
                                prose-ol:list-decimal prose-ol:ml-6 prose-ol:space-y-2 prose-ol:marker:text-red-600
                                prose-li:my-2 prose-li:text-gray-700 prose-li:pl-2">
                        {!! $section->translate('content', $locale) ?? $section->content !!}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Accordion Layout --}}
        <div x-data="{ openAccordion: null }" class="mt-12 space-y-4 animate-fade-in-up" style="animation-delay: 0.5s;">
            @foreach ($page->sections as $index => $section)
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <button @click="openAccordion = openAccordion === {{ $index }} ? null : {{ $index }}"
                        class="flex justify-between items-center w-full px-6 md:px-8 py-5 text-left font-bold text-lg transition-all duration-300"
                        :class="openAccordion === {{ $index }} ?
                            'bg-gradient-to-r from-red-50 to-red-100 text-red-600' :
                            'text-gray-900 hover:bg-gray-50'">
                        <span class="flex items-center space-x-3">
                            @if ($section->icon)
                                <span class="text-2xl">{!! $section->icon !!}</span>
                            @endif
                            <span>{{ $section->translate('title', $locale) ?? $section->title }}</span>
                        </span>
                        <svg class="w-6 h-6 transform transition-transform duration-300 flex-shrink-0"
                            :class="openAccordion === {{ $index }} ? 'rotate-180 text-red-600' : 'text-gray-400'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="openAccordion === {{ $index }}" x-collapse
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        class="px-6 md:px-8 py-6 bg-white border-t border-gray-100">
                        <div
                            class="prose prose-lg max-w-none
                                    prose-headings:text-gray-900
                                    prose-p:text-gray-700 prose-p:leading-relaxed
                                    prose-a:text-red-600 hover:prose-a:text-red-700
                                    prose-ul:list-disc prose-ul:ml-6 prose-ul:space-y-2 prose-ul:marker:text-red-600
                                    prose-ol:list-decimal prose-ol:ml-6 prose-ol:space-y-2 prose-ol:marker:text-red-600
                                    prose-li:my-2 prose-li:text-gray-700 prose-li:pl-2">
                            {!! $section->translate('content', $locale) ?? $section->content !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endif
