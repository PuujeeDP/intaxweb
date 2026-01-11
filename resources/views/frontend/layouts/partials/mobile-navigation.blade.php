{{-- Mobile menu --}}
@php
    // Use the active navigation menu from session
    $activeMenu = session('active_navigation_menu', 'primary');
    $mobileMenu = \App\Helpers\MenuHelper::getData($activeMenu, current_locale());
@endphp

<div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95" class="md:hidden border-t border-gray-200"
    style="display: none;">
    <div class="px-2 pt-2 pb-3 space-y-1 bg-white">
        @if (!empty($mobileMenu))
            @foreach ($mobileMenu as $item)
                @if (empty($item['children']))
                    {{-- Simple Link --}}
                    <a href="{{ $item['url'] }}"
                        class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600 {{ $item['css_class'] ?? '' }}"
                        @if ($item['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                        @if ($item['icon'])
                            <span class="mr-2">{{ $item['icon'] }}</span>
                        @endif
                        {{ $item['title'] }}
                    </a>
                @else
                    {{-- Expandable Menu --}}
                    <div x-data="{ expanded: false }">
                        <button @click="expanded = !expanded"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600 {{ $item['css_class'] ?? '' }}">
                            <span>
                                @if ($item['icon'])
                                    <span class="mr-2">{{ $item['icon'] }}</span>
                                @endif
                                {{ $item['title'] }}
                            </span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="expanded" class="pl-6 space-y-1 mt-1">
                            @foreach ($item['children'] as $child)
                                <a href="{{ $child['url'] }}"
                                    class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-green-50 hover:text-green-600 {{ $child['css_class'] ?? '' }}"
                                    @if ($child['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                    @if ($child['icon'])
                                        <span class="mr-2">{{ $child['icon'] }}</span>
                                    @endif
                                    {{ $child['title'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            {{-- Fallback to hardcoded menu --}}
            <a href="{{ localized_route('home') }}"
                class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600">
                Нүүр
            </a>
            <a href="{{ route('pages.show', ['locale' => app()->getLocale(), 'slug' => 'about']) }}"
                class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600">
                Бидний тухай
            </a>
            <a href="{{ localized_route('services.index') }}"
                class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600">
                Үйлчилгээ
            </a>
            <a href="{{ localized_route('team.index') }}"
                class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600">
                Баг
            </a>
            <a href="{{ localized_route('posts.index') }}"
                class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600">
                Блог
            </a>
            <a href="{{ localized_route('contact.index') }}"
                class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:bg-green-50 hover:text-green-600">
                Холбоо барих
            </a>
        @endif


    </div>
</div>
