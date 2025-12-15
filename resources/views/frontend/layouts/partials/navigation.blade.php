{{-- Desktop Navigation --}}
@php
    // Get menu slugs dynamically from topmenu
    $topMenuItems = \App\Helpers\MenuHelper::getData('topmenu', current_locale());
    $menuSlugs = ['primary']; // default fallback

    if (!empty($topMenuItems)) {
        $menuSlugs = [];
        foreach ($topMenuItems as $topMenuItem) {
            $slug = $topMenuItem['navigation_menu_slug'] ?? 'primary';
            if (!in_array($slug, $menuSlugs)) {
                $menuSlugs[] = $slug;
            }
        }
    }

    // If no menu slugs found, use defaults
    if (empty($menuSlugs)) {
        $menuSlugs = ['primary', 'course', 'audit', 'tax', 'software'];
    }

    $allMenus = [];
    foreach ($menuSlugs as $slug) {
        $allMenus[$slug] = \App\Helpers\MenuHelper::getData($slug, current_locale());
    }
@endphp

<div class="hidden md:flex md:items-center md:space-x-6">

    {{-- Render each menu with x-show instead of x-if --}}
    @foreach ($allMenus as $slug => $menuItems)
        <div x-show="activeNavigationMenu === '{{ $slug }}'" class="flex items-center space-x-6"
            style="display: none;">
            @if (!empty($menuItems))
                @foreach ($menuItems as $item)
                    @if (empty($item['children']))
                        {{-- Simple Link --}}
                        <a href="{{ $item['url'] }}"
                            class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition {{ $item['css_class'] ?? '' }}"
                            @if ($item['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                            @if ($item['icon'])
                                <span class="mr-1">{{ $item['icon'] }}</span>
                            @endif
                            {{ $item['title'] }}
                        </a>
                    @else
                        {{-- Dropdown Menu --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-1 text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition {{ $item['css_class'] ?? '' }}">
                                @if ($item['icon'])
                                    <span class="mr-1">{{ $item['icon'] }}</span>
                                @endif
                                <span>{{ $item['title'] }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-1 z-50"
                                style="display: none;">
                                @foreach ($item['children'] as $child)
                                    <a href="{{ $child['url'] }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition {{ $child['css_class'] ?? '' }}"
                                        @if ($child['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                        @if ($child['icon'])
                                            <span class="mr-1">{{ $child['icon'] }}</span>
                                        @endif
                                        {{ $child['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                {{-- Fallback menu for {{ $slug }} --}}
                @if ($slug === 'primary')
                    <a href="{{ localized_route('home') }}"
                        class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition">
                        {{ __('frontend.home') }}
                    </a>
                    <a href="{{ localized_route('about.index') }}"
                        class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition">
                        {{ __('frontend.about') }}
                    </a>
                    <a href="{{ localized_route('services.index') }}"
                        class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition">
                        {{ __('frontend.services') }}
                    </a>
                    <a href="{{ localized_route('team.index') }}"
                        class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition">
                        {{ __('frontend.team') }}
                    </a>
                    <a href="{{ localized_route('posts.index') }}"
                        class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition">
                        {{ __('frontend.blog_posts') }}
                    </a>
                    <a href="{{ localized_route('contact.index') }}"
                        class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-semibold transition">
                        {{ __('frontend.contact') }}
                    </a>
                @endif
            @endif

            {{-- Search Button (always visible) --}}
            <button @click="$dispatch('open-search')"
                class="text-gray-700 hover:text-green-600 p-2 rounded-lg transition" aria-label="Search">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>
    @endforeach
</div>
