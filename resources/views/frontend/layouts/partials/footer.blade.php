<footer class="bg-gray-900 text-gray-300 border-t-4 border-green-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            {{-- Company Info --}}
            <div>
                <div class="flex items-center space-x-2 mb-6">
                    @if ($siteLogo)
                        <img src="{{ $siteLogo->url }}" alt="{{ $siteName }}" class="h-12 w-auto">
                    @else
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center shadow-lg">
                            <span class="text-2xl font-bold text-white">M</span>
                        </div>
                        <h3 class="text-white text-2xl font-bold">{{ $siteName ?? 'Magic' }}</h3>
                    @endif
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    {{ $footerAbout ?? '' }}
                </p>
                <div class="flex space-x-4">
                    @if ($socialFacebook)
                        <a href="{{ $socialFacebook }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 hover:bg-green-700 rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                    @endif
                    @if ($socialTwitter)
                        <a href="{{ $socialTwitter }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 hover:bg-green-700 rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    @endif
                    @if ($socialInstagram)
                        <a href="{{ $socialInstagram }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 hover:bg-green-700 rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                    @endif
                    @if ($socialLinkedin)
                        <a href="{{ $socialLinkedin }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 hover:bg-green-700 rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    @endif
                    @if ($socialYoutube)
                        <a href="{{ $socialYoutube }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 hover:bg-green-700 rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 text-lg uppercase tracking-wider">{{ __('frontend.timetable') }}
                </h4>
                <ul class="space-y-3">
                    <li>
                        Да - Ба 9:00 AM - 6:00 PM
                    </li>
                    <li>
                        Бя - Ня Амарна
                    </li>
                    <li>
                        Баярын өдөр Амарна
                    </li>
                </ul>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-bold mb-6 text-lg uppercase tracking-wider">{{ __('frontend.quick_links') }}
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ localized_route('home') }}"
                            class="text-gray-400 hover:text-green-500 transition flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                            {{ __('frontend.about') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ localized_route('posts.index') }}"
                            class="text-gray-400 hover:text-green-500 transition flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                            {{ __('frontend.news_articles') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ localized_route('posts.index') }}"
                            class="text-gray-400 hover:text-green-500 transition flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                            {{ __('frontend.services') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ localized_route('contact.submit') }}"
                            class="text-gray-400 hover:text-green-500 transition flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                            {{ __('frontend.contact_us_footer') }}</a>
                    </li>

                </ul>
            </div>

            {{-- Resources --}}
            <div>
                <h4 class="text-white font-bold mb-6 text-lg uppercase tracking-wider">&nbsp;
                </h4>
                @if ($footerMenu)
                    <ul class="space-y-3">
                        @foreach ($footerMenu->rootItems as $item)
                            <li>
                                <a href="{{ $item->getUrl() }}"
                                    @if ($item->target) target="{{ $item->target }}" @endif
                                    class="text-gray-400 hover:text-green-500 transition flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                    {{ $item->getTitle() }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-gray-800 mt-12 pt-8 grid grid-cols-1 md:grid-cols-2 ">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">

                    {{ $footerCopyright ?? '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.' }}
                </p>

            </div>
            <div class="text-right">
                <a href="https://www.primeglobal.net/" target="_blank"
                    class="text-gray-400 hover:text-green-500 transition text-sm">
                    <img src="/images/primegloabal_member.png" alt="PrimeGlobal member" class="h-12 float-right">
                </a>
            </div>
        </div>

        {{-- Scroll to Top Button --}}
        <div x-data="{ show: false }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            @scroll.window="show = (window.pageYOffset > 300)" class="fixed bottom-8 right-8 z-50">
            <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="w-12 h-12 bg-green-600 hover:bg-green-700 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                aria-label="Scroll to top">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 10l7-7m0 0l7 7m-7-7v18">
                    </path>
                </svg>
            </button>
        </div>
</footer>
