{{-- Top Menu with Primary Color Background --}}
@php
    $topMenu = \App\Helpers\MenuHelper::getData('topmenu', current_locale());
    $currentUrl = url()->current();
    $isHomePage = request()->routeIs('home');

    // Function to check if current URL belongs to a specific menu
    function isUrlInMenu($menuSlug, $currentUrl) {
        $menuItems = \App\Helpers\MenuHelper::getData($menuSlug, current_locale());
        if (empty($menuItems)) {
            return false;
        }

        foreach ($menuItems as $item) {
            // Check main item URL
            if ($currentUrl === $item['url'] || str_starts_with($currentUrl, rtrim($item['url'], '/') . '/')) {
                return true;
            }

            // Check children URLs if exists
            if (!empty($item['children'])) {
                foreach ($item['children'] as $child) {
                    if ($currentUrl === $child['url'] || str_starts_with($currentUrl, rtrim($child['url'], '/') . '/')) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
@endphp

{{-- Full Width Top Menu (Desktop & Mobile) --}}
<div class="w-full">
    {{-- Desktop Top Menu --}}
    <div class="hidden md:flex items-center justify-between h-12">
        {{-- Left side - Menu items --}}
        <div class="flex items-center space-x-4 lg:space-x-6">
            @if (!empty($topMenu))
                @foreach ($topMenu as $index => $item)
                    @php
                        $menuSlug = !empty($item['navigation_menu_slug'])
                            ? $item['navigation_menu_slug']
                            : 'primary';

                        // Check if current URL is in this menu
                        $isUrlInThisMenu = isUrlInMenu($menuSlug, $currentUrl);

                        // Fallback: check the top menu item URL itself
                        if (!$isUrlInThisMenu) {
                            $isUrlInThisMenu = $currentUrl === $item['url'] || str_starts_with($currentUrl, rtrim($item['url'], '/') . '/');
                        }

                        // If on homepage and this is the first menu item, mark it as active
                        if ($isHomePage && $index === 0 && !$isUrlInThisMenu) {
                            $isUrlInThisMenu = true;
                        }
                    @endphp

                    @if (empty($item['children']))
                        {{-- Simple Link --}}
                        <a href="{{ $item['url'] }}{{ strpos($item['url'], '?') !== false ? '&' : '?' }}menu={{ $menuSlug }}"
                            @click="activeNavigationMenu = '{{ $menuSlug }}'"
                            :class="activeNavigationMenu === '{{ $menuSlug }}' ? 'bg-white text-green-600' : ''"
                            class="text-white hover:bg-white hover:text-green-600 px-3 py-5 text-sm font-medium transition-all duration-200 rounded {{ $item['css_class'] ?? '' }}"
                            @if ($item['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                            @if ($item['icon'])
                                <span class="mr-1">{{ $item['icon'] }}</span>
                            @endif
                            {{ $item['title'] }}

                        </a>
                    @else
                        {{-- Dropdown Menu --}}
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open; activeNavigationMenu = '{{ $menuSlug }}'"
                                @click.away="open = false"
                                :class="activeNavigationMenu === '{{ $menuSlug }}' ? 'bg-white text-green-600' : ''"
                                class="flex items-center space-x-1 text-white hover:bg-white hover:text-green-600 px-3 py-2 text-sm font-medium transition-all duration-200 rounded {{ $item['css_class'] ?? '' }}">
                                @if ($item['icon'])
                                    <span class="mr-1">{{ $item['icon'] }}</span>
                                @endif
                                <span>{{ $item['title'] }}</span>
                                <span class="text-xs opacity-50">[{{ $menuSlug }}]</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
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
                                    @php
                                        $isChildActive = $currentUrl === $child['url'];
                                    @endphp
                                    <a href="{{ $child['url'] }}{{ strpos($child['url'], '?') !== false ? '&' : '?' }}menu={{ $menuSlug }}"
                                        class="block px-4 py-2 text-sm transition {{ $isChildActive ? 'bg-green-600 text-white font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }} {{ $child['css_class'] ?? '' }}"
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
                {{-- Fallback menu if no top menu is configured --}}
                <a href="{{ localized_route('home') }}"
                    class="text-white hover:bg-white hover:text-green-600 px-2 lg:px-3 py-2 text-xs lg:text-sm font-medium transition-all duration-200 rounded {{ request()->routeIs('home') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.home') }}
                </a>
                <a href="{{ localized_route('about.index') }}"
                    class="text-white hover:bg-white hover:text-green-600 px-2 lg:px-3 py-2 text-xs lg:text-sm font-medium transition-all duration-200 rounded {{ request()->routeIs('about.*') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.about') }}
                </a>
                <a href="{{ localized_route('services.index') }}"
                    class="text-white hover:bg-white hover:text-green-600 px-2 lg:px-3 py-2 text-xs lg:text-sm font-medium transition-all duration-200 rounded {{ request()->routeIs('services.*') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.services') }}
                </a>
                <a href="{{ localized_route('contact.index') }}"
                    class="text-white hover:bg-white hover:text-green-600 px-2 lg:px-3 py-2 text-xs lg:text-sm font-medium transition-all duration-200 rounded {{ request()->routeIs('contact.*') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.contact') }}
                </a>
            @endif
        </div>

        {{-- Right side - Language selector --}}
        <div class="flex items-center">
            {{-- Language Selector --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center space-x-1 text-white hover:bg-white hover:text-green-600 px-3 py-2 text-sm font-medium transition-all duration-200 rounded">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                        </path>
                    </svg>
                    <span class="hidden lg:inline">{{ locale_name(current_locale()) }}</span>
                    <span class="lg:hidden">{{ strtoupper(current_locale()) }}</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- Language Dropdown --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-xl border border-gray-200 py-1 z-50"
                    style="display: none;">
                    @foreach (available_locales() as $code => $name)
                        <a href="{{ switch_locale_url($code) }}"
                            class="block px-4 py-2 text-sm transition {{ current_locale() === $code ? 'bg-green-600 text-white font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                            {{ $name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Top Menu Bar --}}
    <div class="md:hidden flex items-center justify-between h-12 px-4">
        {{-- Menu Toggle Button --}}
        <button @click="mobileTopMenuOpen = !mobileTopMenuOpen"
            class="flex items-center space-x-2 text-white hover:text-white/80 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!mobileTopMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16"></path>
                <path x-show="mobileTopMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="text-sm font-medium">{{ __('frontend.menu') }}</span>
        </button>

        {{-- Language selector on mobile --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false"
                class="flex items-center space-x-1 text-white hover:text-white/80 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                    </path>
                </svg>
                <span class="text-sm font-medium">{{ strtoupper(current_locale()) }}</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            {{-- Mobile Language Dropdown --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="absolute right-0 mt-2 w-36 bg-white rounded-lg shadow-xl border border-gray-200 py-1 z-50"
                style="display: none;">
                @foreach (available_locales() as $code => $name)
                    <a href="{{ switch_locale_url($code) }}"
                        class="block px-4 py-2 text-sm transition {{ current_locale() === $code ? 'bg-green-600 text-white font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Mobile Vertical Menu Dropdown --}}
    <div x-show="mobileTopMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-green-700 border-t border-green-800"
        style="display: none;">
        <div class="px-4 py-3 space-y-1">
            @if (!empty($topMenu))
                @foreach ($topMenu as $index => $item)
                    @php
                        $menuSlug = !empty($item['navigation_menu_slug'])
                            ? $item['navigation_menu_slug']
                            : 'primary';

                        // Check if current URL is in this menu
                        $isActive = isUrlInMenu($menuSlug, $currentUrl);

                        // Fallback: check the top menu item URL itself
                        if (!$isActive) {
                            $isActive = $currentUrl === $item['url'] || str_starts_with($currentUrl, rtrim($item['url'], '/') . '/');
                        }

                        // If on homepage and this is the first menu item, mark it as active
                        if ($isHomePage && $index === 0 && !$isActive) {
                            $isActive = true;
                        }
                    @endphp

                    @if (empty($item['children']))
                        {{-- Simple Link --}}
                        <a href="{{ $item['url'] }}{{ strpos($item['url'], '?') !== false ? '&' : '?' }}menu={{ $menuSlug }}"
                            @click="mobileTopMenuOpen = false; activeNavigationMenu = '{{ $menuSlug }}'"
                            :class="activeNavigationMenu === '{{ $menuSlug }}' ? 'bg-white text-green-600' : ''"
                            class="block text-white hover:bg-green-600 px-3 py-2.5 text-sm font-medium rounded-md transition {{ $item['css_class'] ?? '' }}"
                            @if ($item['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                            @if ($item['icon'])
                                <span class="mr-2">{{ $item['icon'] }}</span>
                            @endif
                            {{ $item['title'] }}
                        </a>
                    @else
                        {{-- Dropdown Menu (Accordion style for mobile) --}}
                        <div class="space-y-1" x-data="{ open: false }">
                            <button
                                @click="open = !open; activeNavigationMenu = '{{ $menuSlug }}'"
                                :class="activeNavigationMenu === '{{ $menuSlug }}' ? 'bg-white text-green-600' : ''"
                                class="w-full flex items-center justify-between text-white hover:bg-green-600 px-3 py-2.5 text-sm font-medium rounded-md transition {{ $item['css_class'] ?? '' }}">
                                <span class="flex items-center">
                                    @if ($item['icon'])
                                        <span class="mr-2">{{ $item['icon'] }}</span>
                                    @endif
                                    {{ $item['title'] }}
                                </span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Submenu --}}
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 space-y-1"
                                style="display: none;">
                                @foreach ($item['children'] as $child)
                                    @php
                                        $isChildActive = $currentUrl === $child['url'];
                                    @endphp
                                    <a href="{{ $child['url'] }}{{ strpos($child['url'], '?') !== false ? '&' : '?' }}menu={{ $menuSlug }}" @click="mobileTopMenuOpen = false"
                                        class="block text-white hover:bg-green-600 px-3 py-2 text-sm rounded-md transition {{ $isChildActive ? 'bg-white text-green-600 font-medium' : '' }} {{ $child['css_class'] ?? '' }}"
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
                {{-- Fallback menu if no top menu is configured --}}
                <a href="{{ localized_route('home') }}" @click="mobileTopMenuOpen = false"
                    class="block text-white hover:bg-green-600 px-3 py-2.5 text-sm font-medium rounded-md transition {{ request()->routeIs('home') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.home') }}
                </a>
                <a href="{{ localized_route('about.index') }}" @click="mobileTopMenuOpen = false"
                    class="block text-white hover:bg-green-600 px-3 py-2.5 text-sm font-medium rounded-md transition {{ request()->routeIs('about.*') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.about') }}
                </a>
                <a href="{{ localized_route('services.index') }}" @click="mobileTopMenuOpen = false"
                    class="block text-white hover:bg-green-600 px-3 py-2.5 text-sm font-medium rounded-md transition {{ request()->routeIs('services.*') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.services') }}
                </a>
                <a href="{{ localized_route('contact.index') }}" @click="mobileTopMenuOpen = false"
                    class="block text-white hover:bg-green-600 px-3 py-2.5 text-sm font-medium rounded-md transition {{ request()->routeIs('contact.*') ? 'bg-white text-green-600' : '' }}">
                    {{ __('frontend.contact') }}
                </a>
            @endif
        </div>
    </div>
</div>
