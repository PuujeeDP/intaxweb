@php
    // Get active navigation menu from session (set by TrackActiveNavigationMenu middleware)
    $activeNavigationMenu = session('active_navigation_menu', 'primary');
@endphp

<header class="sticky top-0 z-50" x-data="{
    mobileMenuOpen: false,
    languageMenuOpen: false,
    mobileTopMenuOpen: false,
    activeNavigationMenu: '{{ $activeNavigationMenu }}'
}">
    {{-- Top Menu Bar --}}
    <div class="bg-green-600 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('frontend.layouts.partials.top-menu')
        </div>
    </div>

    {{-- Main Navigation --}}
    <nav class="bg-white/95 backdrop-blur-sm shadow-lg border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ localized_route('home') }}" class="flex items-center space-x-2">
                        @if($siteLogo)
                            <img src="{{ $siteLogo->url }}" alt="{{ $siteName }}" class="h-12 w-auto">
                        @else
                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">M</span>
                            </div>
                            <span class="text-2xl font-bold text-gray-900">{{ $siteName ?? 'Magic' }}<span class="text-green-600">CMS</span></span>
                        @endif
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                @include('frontend.layouts.partials.navigation')

                {{-- Mobile menu button --}}
                <div class="md:hidden">
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="text-gray-700 hover:text-green-600 p-2"
                        aria-label="Toggle menu">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu --}}
            @include('frontend.layouts.partials.mobile-navigation')
        </div>
    </nav>
</header>

{{-- Search Modal --}}
<div x-data="{ searchOpen: false }"
     @open-search.window="searchOpen = true"
     x-show="searchOpen"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-start justify-center min-h-screen pt-20 px-4">
        {{-- Backdrop --}}
        <div x-show="searchOpen"
             @click="searchOpen = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
             aria-hidden="true"></div>

        {{-- Search Box --}}
        <div x-show="searchOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full border-4 border-green-600">
            <form action="{{ localized_route('posts.index') }}" method="GET" class="p-6">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        x-ref="searchInput"
                        placeholder="{{ __('frontend.search_placeholder') }}"
                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-green-500 focus:border-green-600 text-lg"
                        autofocus>
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <button type="submit" class="mt-4 w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition">
                    {{ __('frontend.search') }}
                </button>
            </form>
        </div>
    </div>
</div>
