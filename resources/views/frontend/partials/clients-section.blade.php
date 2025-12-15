{{-- Clients Section - Infinite Scroll --}}
@if ($clients->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('frontend.customers') }}</h2>
                <p class="text-xl text-gray-600">{{ __('frontend.customers_description') }}</p>
            </div>

            {{-- Infinite Scrolling Logos --}}
            <div class="relative overflow-hidden" x-data="{ isPaused: false }">
                {{-- Gradient overlays for smooth fade effect --}}
                <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>

                <div class="flex animate-scroll"
                     @mouseenter="isPaused = true; $el.style.animationPlayState = 'paused'"
                     @mouseleave="isPaused = false; $el.style.animationPlayState = 'running'"
                     style="animation: scroll 40s linear infinite;">

                    {{-- First set of logos --}}
                    @foreach ($clients as $client)
                        <div class="flex-shrink-0 w-48 px-8 py-6">
                            <div class="bg-white rounded-lg p-6 h-28 flex items-center justify-center hover:shadow-lg transition-all duration-300 group">
                                @if ($client->logo)
                                    @if ($client->website)
                                        <a href="{{ $client->website }}" target="_blank" rel="noopener noreferrer"
                                            class="block w-full h-full flex items-center justify-center">
                                            <img src="{{ $client->logo->url }}"
                                                alt="{{ $client->name }}"
                                                class="max-w-full max-h-16 object-contain grayscale group-hover:grayscale-0 transition-all duration-300"
                                                title="{{ $client->name }}">
                                        </a>
                                    @else
                                        <img src="{{ $client->logo->url }}"
                                            alt="{{ $client->name }}"
                                            class="max-w-full max-h-16 object-contain grayscale group-hover:grayscale-0 transition-all duration-300"
                                            title="{{ $client->name }}">
                                    @endif
                                @else
                                    <div class="text-center">
                                        <p class="text-gray-600 font-semibold text-sm">{{ $client->name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Duplicate set for seamless loop --}}
                    @foreach ($clients as $client)
                        <div class="flex-shrink-0 w-48 px-8 py-6">
                            <div class="bg-white rounded-lg p-6 h-28 flex items-center justify-center hover:shadow-lg transition-all duration-300 group">
                                @if ($client->logo)
                                    @if ($client->website)
                                        <a href="{{ $client->website }}" target="_blank" rel="noopener noreferrer"
                                            class="block w-full h-full flex items-center justify-center">
                                            <img src="{{ $client->logo->url }}"
                                                alt="{{ $client->name }}"
                                                class="max-w-full max-h-16 object-contain grayscale group-hover:grayscale-0 transition-all duration-300"
                                                title="{{ $client->name }}">
                                        </a>
                                    @else
                                        <img src="{{ $client->logo->url }}"
                                            alt="{{ $client->name }}"
                                            class="max-w-full max-h-16 object-contain grayscale group-hover:grayscale-0 transition-all duration-300"
                                            title="{{ $client->name }}">
                                    @endif
                                @else
                                    <div class="text-center">
                                        <p class="text-gray-600 font-semibold text-sm">{{ $client->name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <style>
            @keyframes scroll {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-scroll {
                display: flex;
                width: max-content;
            }
        </style>
    </section>
@endif
