{{-- Clients Section - Modern Grid Design --}}
@if ($clients->count() > 0)
    <section class="py-10 lg:py-18  bg-gray-300 relative overflow-hidden">
        {{-- Background decoration --}}
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-gray-100 rounded-full opacity-50 translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-72 h-72 bg-gray-50 rounded-full opacity-60 -translate-x-1/3 translate-y-1/3">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-5"
                    style="font-family: 'Open Sans', sans-serif;">
                    {{ __('frontend.customers') ?? 'Манай харилцагчид' }}
                </h2>
                <p class="text-gray-600">
                    {{ __('frontend.customers_description') ?? 'Бидэнтэй хамтран ажилладаг байгууллагууд' }}
                </p>
            </div>

            {{-- Clients Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach ($clients as $client)
                    <div
                        class="group relative bg-gray-50 rounded-xl p-6 hover:bg-white hover:shadow-lg transition-all duration-300 border border-transparent hover:border-gray-100">
                        @if ($client->logo)
                            @if ($client->website)
                                <a href="{{ $client->website }}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center justify-center h-20">
                                    <img src="{{ $client->logo->url }}" alt="{{ $client->name }}"
                                        class="max-w-full max-h-16 object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                                        title="{{ $client->name }}">
                                </a>
                            @else
                                <div class="flex items-center justify-center h-20">
                                    <img src="{{ $client->logo->url }}" alt="{{ $client->name }}"
                                        class="max-w-full max-h-16 object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                                        title="{{ $client->name }}">
                                </div>
                            @endif
                        @else
                            <div class="flex items-center justify-center h-20">
                                <p
                                    class="text-gray-500 font-medium text-sm text-center group-hover:text-gray-900 transition-colors duration-300">
                                    {{ $client->name }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
