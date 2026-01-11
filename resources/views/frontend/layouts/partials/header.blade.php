@php
    $primaryMenu = \App\Helpers\MenuHelper::getData('primary', current_locale());
@endphp

<header class="header-main bg-white sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 lg:h-24">
            {{-- Logo --}}
            <a href="{{ localized_route('home') }}" class="flex items-center gap-3 lg:gap-4">
                @if ($siteLogo)
                    <img src="{{ $siteLogo->url }}" alt="{{ $siteName }}" class="h-12 lg:h-14 w-auto">
                @else
                    <img src="/images/intax_logo.jpg" alt="inTax S Counsel" class="h-12 lg:h-14 w-auto">
                @endif
                <div class="flex flex-col">

                </div>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-8 xl:gap-10">
                @if (!empty($primaryMenu))
                    @foreach ($primaryMenu as $item)
                        @if (empty($item['children']))
                            <a href="{{ $item['url'] }}"
                                class="text-gray-900 hover:text-[#d40c19] font-medium text-sm relative py-2 transition-all duration-300 group"
                                @if ($item['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                {{ $item['title'] }}
                                <span
                                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#d40c19] transition-all duration-300 group-hover:w-full"></span>
                            </a>
                        @else
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center gap-1 text-gray-900 hover:text-[#d40c19] font-medium text-sm py-2 transition-all duration-300">
                                    {{ $item['title'] }}
                                    <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50"
                                    style="display: none;">
                                    @foreach ($item['children'] as $child)
                                        <a href="{{ $child['url'] }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-[#d40c19] transition"
                                            @if ($child['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $child['title'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    {{-- Default menu items --}}
                    <a href="{{ localized_route('home') }}"
                        class="text-gray-900 hover:text-[#d40c19] font-medium text-sm relative py-2 transition-all duration-300 group {{ request()->routeIs('home') ? 'text-[#d40c19]' : '' }}">
                        {{ __('frontend.home') }}
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#d40c19] transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ localized_route('services.index') }}"
                        class="text-gray-900 hover:text-[#d40c19] font-medium text-sm relative py-2 transition-all duration-300 group {{ request()->routeIs('services.*') ? 'text-[#d40c19]' : '' }}">
                        {{ __('frontend.services') }}
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#d40c19] transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('pages.show', ['locale' => app()->getLocale(), 'slug' => 'about']) }}"
                        class="text-gray-900 hover:text-[#d40c19] font-medium text-sm relative py-2 transition-all duration-300 group {{ request()->segment(3) === 'about' ? 'text-[#d40c19]' : '' }}">
                        {{ __('frontend.about') }}
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#d40c19] transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ localized_route('posts.index') }}"
                        class="text-gray-900 hover:text-[#d40c19] font-medium text-sm relative py-2 transition-all duration-300 group {{ request()->routeIs('posts.*') ? 'text-[#d40c19]' : '' }}">
                        {{ __('frontend.news') }}
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#d40c19] transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ localized_route('contact.index') }}"
                        class="text-gray-900 hover:text-[#d40c19] font-medium text-sm relative py-2 transition-all duration-300 group {{ request()->routeIs('contact.*') ? 'text-[#d40c19]' : '' }}">
                        {{ __('frontend.contact') }}
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#d40c19] transition-all duration-300 group-hover:w-full"></span>
                    </a>
                @endif
            </nav>

            {{-- Language Switcher & CTA --}}
            <div class="hidden lg:flex items-center gap-4">
                {{-- Language Switcher --}}
                <div class="flex items-center gap-1">
                    @foreach (available_locales() as $code => $name)
                        <a href="{{ switch_locale_url($code) }}"
                            class="px-2.5 py-1.5 text-xs font-semibold rounded transition-all duration-300
                                  {{ current_locale() === $code
                                      ? 'bg-[#d40c19] text-white'
                                      : 'bg-gray-100 text-gray-600 hover:bg-[#d40c19] hover:text-white' }}">
                            {{ strtoupper($code) }}
                        </a>
                    @endforeach
                </div>

                {{-- CTA Button --}}
                <a href="{{ localized_route('contact.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 text-white font-semibold text-sm rounded-md transition-all duration-300 hover:-translate-y-0.5"
                    style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%); box-shadow: 0 4px 15px rgba(227, 27, 35, 0.3);">
                    {{ __('frontend.get_consultation') ?? 'Зөвлөгөө авах' }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            </div>

            {{-- Mobile menu button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden p-2 text-gray-700 hover:text-[#d40c19] transition" aria-label="Toggle menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden border-t border-gray-100 py-4"
            style="display: none;">
            <nav class="flex flex-col gap-1">
                @if (!empty($primaryMenu))
                    @foreach ($primaryMenu as $item)
                        @if (empty($item['children']))
                            <a href="{{ $item['url'] }}" @click="mobileMenuOpen = false"
                                class="px-4 py-3 text-gray-900 hover:bg-red-50 hover:text-[#d40c19] font-medium rounded-lg transition"
                                @if ($item['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                {{ $item['title'] }}
                            </a>
                        @else
                            <div x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-900 hover:bg-red-50 hover:text-[#d40c19] font-medium rounded-lg transition">
                                    {{ $item['title'] }}
                                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" class="ml-4 mt-1 space-y-1" style="display: none;">
                                    @foreach ($item['children'] as $child)
                                        <a href="{{ $child['url'] }}" @click="mobileMenuOpen = false"
                                            class="block px-4 py-2 text-sm text-gray-600 hover:text-[#d40c19] transition"
                                            @if ($child['target'] === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $child['title'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <a href="{{ localized_route('home') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 text-gray-900 hover:bg-red-50 hover:text-[#d40c19] font-medium rounded-lg transition">{{ __('frontend.home') }}</a>
                    <a href="{{ localized_route('services.index') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 text-gray-900 hover:bg-red-50 hover:text-[#d40c19] font-medium rounded-lg transition">{{ __('frontend.services') }}</a>
                    <a href="{{ route('pages.show', ['locale' => app()->getLocale(), 'slug' => 'about']) }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 text-gray-900 hover:bg-red-50 hover:text-[#d40c19] font-medium rounded-lg transition">{{ __('frontend.about') }}</a>
                    <a href="{{ localized_route('posts.index') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 text-gray-900 hover:bg-red-50 hover:text-[#d40c19] font-medium rounded-lg transition">{{ __('frontend.news') }}</a>
                    <a href="{{ localized_route('contact.index') }}" @click="mobileMenuOpen = false"
                        class="px-4 py-3 text-gray-900 hover:bg-red-50 hover:text-[#d40c19] font-medium rounded-lg transition">{{ __('frontend.contact') }}</a>
                @endif

                {{-- Mobile Language Switcher --}}
                <div class="flex items-center justify-center gap-2 px-4 mt-4 pt-4 border-t border-gray-100">
                    @foreach (available_locales() as $code => $name)
                        <a href="{{ switch_locale_url($code) }}"
                            class="px-4 py-2 text-sm font-semibold rounded transition-all duration-300
                                  {{ current_locale() === $code
                                      ? 'bg-[#d40c19] text-white'
                                      : 'bg-gray-100 text-gray-600 hover:bg-[#d40c19] hover:text-white' }}">
                            {{ strtoupper($code) }}
                        </a>
                    @endforeach
                </div>

                {{-- Mobile CTA --}}
                <a href="{{ localized_route('contact.index') }}" @click="mobileMenuOpen = false"
                    class="mx-4 mt-4 flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold text-sm rounded-md"
                    style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%);">
                    {{ __('frontend.get_consultation') ?? 'Зөвлөгөө авах' }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            </nav>
        </div>
    </div>
</header>
