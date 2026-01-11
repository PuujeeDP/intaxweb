{{-- Services Grid Partial - Same style as Home page --}}
<section class="py-20 lg:py-28 bg-white relative" id="services">
    <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-gray-50 to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-5" style="font-family: 'Open Sans', sans-serif;">
                {{ __('frontend.our_services') }}
            </h2>

        </div>

        @if ($services->count() > 0)
            {{-- Services Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($services as $service)
                    @php
                        $locale = app()->getLocale();
                        $serviceTitle = $service->translate('title', $locale) ?? $service->title;
                        $serviceDescription = $service->translate('description', $locale) ?? $service->description;
                    @endphp

                    <a href="{{ localized_route('services.show', ['slug' => $service->slug]) }}"
                        class="service-card animate-fade-in-up relative bg-white p-8 rounded-2xl text-center transition-all duration-300 border border-gray-100 hover:-translate-y-2 hover:shadow-xl hover:border-transparent overflow-hidden group"
                        style="animation-delay: {{ $loop->index * 0.05 }}s;">
                        <div class="w-[75px] h-[75px] mx-auto mb-5 rounded-full flex items-center justify-center text-3xl transition-all duration-300 group-hover:scale-110"
                            style="background: linear-gradient(135deg, rgba(212, 12, 25, 0.08) 0%, rgba(212, 12, 25, 0.15) 100%);">
                            <span
                                class="group-hover:brightness-0 group-hover:invert transition-all">{{ $service->icon ?? '📋' }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-[#d40c19] transition-colors duration-300"
                            style="font-family: 'Open Sans', sans-serif;">
                            {{ $serviceTitle }}
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            {{ Str::limit(strip_tags($serviceDescription), 100) }}
                        </p>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center"
                    style="background: linear-gradient(135deg, rgba(212, 12, 25, 0.08) 0%, rgba(212, 12, 25, 0.15) 100%);">
                    <svg class="w-10 h-10 text-[#d40c19]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('frontend.no_services') }}</h3>
                <p class="text-gray-600 mb-8">{{ __('frontend.services_coming') }}</p>
                <a href="{{ localized_route('contact.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-white font-semibold rounded-md transition-all duration-300 hover:-translate-y-0.5"
                    style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%); box-shadow: 0 4px 15px rgba(212, 12, 25, 0.3);">
                    {{ __('frontend.contact_us') }}
                </a>
            </div>
        @endif
    </div>
</section>
