{{-- Team Section --}}
@if (isset($teamMembers) && $teamMembers->count() > 0)
    <section class="py-20 relative overflow-hidden">
        {{-- Background with subtle pattern --}}
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50 via-white to-gray-50"></div>
        <div class="absolute inset-0 opacity-[0.03]">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="team-hexagon" x="0" y="0" width="56" height="100" patternUnits="userSpaceOnUse">
                        <polygon points="28,6 52,18 52,42 28,54 4,42 4,18" fill="none" stroke="#d40c19" stroke-width="1"/>
                        <polygon points="28,56 52,68 52,92 28,104 4,92 4,68" fill="none" stroke="#d40c19" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#team-hexagon)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold text-[#d40c19] bg-red-50 border border-red-100 mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    {{ __('frontend.our_team') }}
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4" style="font-family: 'Open Sans', sans-serif;">
                    {{ __('frontend.our_team_subtitle') }}
                </h2>
            </div>

            {{-- Team Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @foreach ($teamMembers as $index => $member)
                    <div class="animate-fade-in-up" style="animation-delay: {{ ($index % 4) * 0.1 + 0.1 }}s;">
                        <div class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-500 overflow-hidden border border-gray-100">
                            {{-- Top Accent Bar --}}
                            <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #d40c19 0%, #ff4757 100%);"></div>

                            {{-- Photo Section --}}
                            <div class="relative pt-8 pb-4 px-6">
                                {{-- Decorative circles --}}
                                <div class="absolute top-4 right-4 w-12 h-12 bg-red-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="absolute top-8 right-8 w-6 h-6 bg-red-100 rounded-full opacity-30 group-hover:scale-150 transition-transform duration-500 delay-75"></div>

                                {{-- Photo --}}
                                <div class="relative w-32 h-32 mx-auto">
                                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-[#d40c19] to-[#ff4757] p-[3px] group-hover:scale-105 transition-transform duration-300">
                                        <div class="w-full h-full rounded-full bg-white p-[2px]">
                                            @if ($member->photo)
                                                <img src="{{ $member->photo->url }}"
                                                     alt="{{ $member->name }}"
                                                     class="w-full h-full object-cover rounded-full">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                                    <svg class="w-14 h-14 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Member Info --}}
                            <div class="px-6 pb-6 text-center">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#d40c19] transition-colors duration-300">
                                    {{ $member->name }}
                                </h3>

                                @if ($member->position)
                                    <p class="text-sm font-medium text-[#d40c19] mt-1">
                                        {{ $member->position }}
                                    </p>
                                @endif

                                @if ($member->bio)
                                    <p class="text-gray-500 text-sm leading-relaxed mt-3 line-clamp-2">
                                        {{ Str::limit($member->bio, 80) }}
                                    </p>
                                @endif

                                {{-- Contact & Social --}}
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex justify-center items-center space-x-2">
                                        @if ($member->email)
                                            <a href="mailto:{{ $member->email }}"
                                               class="w-9 h-9 bg-gray-50 hover:bg-[#d40c19] rounded-lg flex items-center justify-center text-gray-500 hover:text-white transition-all duration-300"
                                               title="{{ $member->email }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($member->phone)
                                            <a href="tel:{{ $member->phone }}"
                                               class="w-9 h-9 bg-gray-50 hover:bg-[#d40c19] rounded-lg flex items-center justify-center text-gray-500 hover:text-white transition-all duration-300"
                                               title="{{ $member->phone }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($member->facebook)
                                            <a href="{{ $member->facebook }}" target="_blank" rel="noopener noreferrer"
                                               class="w-9 h-9 bg-gray-50 hover:bg-[#1877f2] rounded-lg flex items-center justify-center text-gray-500 hover:text-white transition-all duration-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($member->twitter)
                                            <a href="{{ $member->twitter }}" target="_blank" rel="noopener noreferrer"
                                               class="w-9 h-9 bg-gray-50 hover:bg-black rounded-lg flex items-center justify-center text-gray-500 hover:text-white transition-all duration-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($member->linkedin)
                                            <a href="{{ $member->linkedin }}" target="_blank" rel="noopener noreferrer"
                                               class="w-9 h-9 bg-gray-50 hover:bg-[#0a66c2] rounded-lg flex items-center justify-center text-gray-500 hover:text-white transition-all duration-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
