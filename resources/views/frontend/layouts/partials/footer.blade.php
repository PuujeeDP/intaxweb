<footer class="text-gray-300" style="background-color: #1a1a1a;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16">


            {{-- Services --}}
            <div>
                <h4 class="text-white font-bold text-lg mb-6" style="font-family: 'Open Sans', sans-serif;">
                    {{ __('frontend.services') }}
                </h4>
                <ul class="space-y-3">
                    @foreach ($footerServices ?? [] as $service)
                        @php
                            $locale = app()->getLocale();
                            $serviceTitle = $service->translate('title', $locale) ?? $service->title;
                        @endphp
                        <li>
                            <a href="{{ localized_route('services.show', ['slug' => $service->slug]) }}"
                                class="text-gray-400 hover:text-[#d40c19] transition text-sm">
                                {{ $serviceTitle }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-bold text-lg mb-6" style="font-family: 'Open Sans', sans-serif;">
                    {{ __('frontend.quick_links') }}
                </h4>
                <ul class="space-y-3">
                    @if ($footerMenu && $footerMenu->rootItems->count() > 0)
                        @foreach ($footerMenu->rootItems as $item)
                            <li>
                                <a href="{{ $item->getUrl() }}"
                                    @if ($item->target) target="{{ $item->target }}" @endif
                                    class="text-gray-400 hover:text-[#d40c19] transition text-sm">
                                    {{ $item->getTitle() }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            {{-- Quick Links 2 (from quicklinks menu) --}}
            <div>
                <ul class="space-y-3 mt-12">
                    @if ($quickLinksMenu && $quickLinksMenu->rootItems->count() > 0)
                        @foreach ($quickLinksMenu->rootItems as $item)
                            <li>
                                <a href="{{ $item->getUrl() }}"
                                    @if ($item->target) target="{{ $item->target }}" @endif
                                    class="text-gray-400 hover:text-[#d40c19] transition text-sm">
                                    {{ $item->getTitle() }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>



            {{-- Contact Info --}}
            <div>
                <h4 class="text-white font-bold text-lg mb-6" style="font-family: 'Open Sans', sans-serif;">
                    {{ __('frontend.contact') }}
                </h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#d40c19] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span
                            class="text-gray-400 text-sm">{{ $siteAddress ?? 'Улаанбаатар хот, Сүхбаатар дүүрэг' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#d40c19] flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:{{ $sitePhone ?? '+97611234567' }}"
                            class="text-gray-400 hover:text-[#d40c19] transition text-sm">
                            {{ $sitePhone ?? '+976 11 234 567' }}
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#d40c19] flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:{{ $siteEmail ?? 'info@intax.mn' }}"
                            class="text-gray-400 hover:text-[#d40c19] transition text-sm">
                            {{ $siteEmail ?? 'info@intax.mn' }}
                        </a>
                    </li>
                </ul>

                {{-- Social Links --}}
                <div class="flex items-center gap-3 mt-6">
                    @if ($socialFacebook)
                        <a href="{{ $socialFacebook }}" target="_blank"
                            class="w-10 h-10 bg-white/5 hover:bg-[#d40c19] rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                        </a>
                    @endif
                    @if ($socialLinkedin)
                        <a href="{{ $socialLinkedin }}" target="_blank"
                            class="w-10 h-10 bg-white/5 hover:bg-[#d40c19] rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                                <rect x="2" y="9" width="4" height="12" />
                                <circle cx="4" cy="4" r="2" />
                            </svg>
                        </a>
                    @endif
                    @if ($socialTwitter)
                        <a href="{{ $socialTwitter }}" target="_blank"
                            class="w-10 h-10 bg-white/5 hover:bg-[#d40c19] rounded-lg flex items-center justify-center transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M8.5 11a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm-2.5 8c4.97 0 9-3.58 9-8s-4.03-8-9-8-9 3.58-9 8c0 1.5.44 2.91 1.2 4.1L2 19l4.1-1.2c1.19.76 2.6 1.2 4.4 1.2z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">
                {{ $footerCopyright ?? '© ' . date('Y') . ' inTax S Counsel LLC. Бүх эрх хамгаалагдсан.' }}
            </p>

            {{-- Language Switcher in Footer --}}
            <div class="flex items-center gap-2">
                @foreach (available_locales() as $code => $name)
                    <a href="{{ switch_locale_url($code) }}"
                        class="px-3 py-1.5 text-xs font-semibold rounded transition-all duration-300
                              {{ current_locale() === $code
                                  ? 'bg-[#d40c19] text-white'
                                  : 'bg-white/5 text-gray-400 hover:bg-[#d40c19] hover:text-white' }}">
                        {{ strtoupper($code) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
