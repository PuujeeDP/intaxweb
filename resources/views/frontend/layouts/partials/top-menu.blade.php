{{-- Top Bar with Dark Background --}}
@php
    $topMenu = \App\Helpers\MenuHelper::getData('topmenu', current_locale());
@endphp

<div class="py-3" style="background-color: #1a1a1a;"
    x-data="{ mobileTopMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            {{-- Contact Info --}}
            <div class="hidden md:flex items-center gap-6 lg:gap-8">
                @if ($siteEmail ?? false)
                    <a href="mailto:{{ $siteEmail }}"
                        class="flex items-center gap-2 text-white/70 hover:text-white transition-all duration-300 text-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        {{ $siteEmail }}
                    </a>
                @else
                    <a href="mailto:info@intax.mn"
                        class="flex items-center gap-2 text-white/70 hover:text-white transition-all duration-300 text-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        info@intax.mn
                    </a>
                @endif

                @if ($sitePhone ?? false)
                    <a href="tel:{{ $sitePhone }}"
                        class="flex items-center gap-2 text-white/70 hover:text-white transition-all duration-300 text-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        {{ $sitePhone }}
                    </a>
                @else
                    <a href="tel:+97611234567"
                        class="flex items-center gap-2 text-white/70 hover:text-white transition-all duration-300 text-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        +976 11 234 567
                    </a>
                @endif
            </div>

            {{-- Language Switcher --}}
            <div class="flex items-center gap-2 ml-auto">
                @foreach (available_locales() as $code => $name)
                    <a href="{{ switch_locale_url($code) }}"
                        class="px-3 py-1.5 text-xs font-semibold rounded transition-all duration-300 border
                              {{ current_locale() === $code
                                  ? 'bg-white border-white text-[#d40c19]'
                                  : 'bg-transparent border-white/30 text-white/80 hover:bg-white hover:border-white hover:text-[#d40c19]' }}">
                        {{ strtoupper($code) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
