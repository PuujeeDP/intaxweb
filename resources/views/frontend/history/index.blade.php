@extends('frontend.layouts.app')

@section('title', __('Company History'))

@section('content')
    <!-- Hero Section - Compact -->
    <section class="relative bg-gradient-to-br from-green-600 to-emerald-800 text-white py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-3">
                    {{ __('frontend.companytimeline') }}
                </h1>
                <p class="text-lg text-green-100">
                    {{ __('frontend.companytimeline_text') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Timeline Section - Clean & Compact -->
    <section class="py-12 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            @if ($histories->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500">{{ __('No history items available yet.') }}</p>
                </div>
            @else
                <div class="max-w-4xl mx-auto">
                    @foreach ($histories as $index => $history)
                        <!-- Timeline Item - Simplified -->
                        <div class="relative pl-8 md:pl-12 pb-12 border-l-2 border-gray-200 last:border-0 last:pb-0">
                            <!-- Year Badge - Left Side -->
                            <div
                                class="absolute -left-5 md:-left-6 top-0 w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm md:text-base shadow-lg">
                                {{ substr($history->year, -2) }}
                            </div>

                            <!-- Year Label -->
                            <div class="mb-3">
                                <span
                                    class="inline-block px-3 py-1 bg-green-50 text-green-700 text-sm font-semibold rounded">
                                    {{ $history->year }}
                                </span>
                            </div>

                            <!-- Content Card - Minimal -->
                            <div class="bg-gray-50 rounded-lg p-5 md:p-6 hover:bg-gray-100 transition-colors">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">
                                    {{ $history->translate('title', app()->getLocale()) }}
                                </h3>
                                <div
                                    class="text-gray-600 leading-relaxed prose prose-sm md:prose-base max-w-none prose-ul:list-disc prose-ul:ml-4 prose-ol:list-decimal prose-ol:ml-4 prose-li:mb-1">
                                    {!! $history->translate('description', app()->getLocale()) !!}
                                </div>

                                @if ($history->image)
                                    <div class="mt-4">
                                        <img src="{{ Storage::url($history->image->path) }}"
                                            alt="{{ $history->translate('title', app()->getLocale()) }}"
                                            class="rounded-lg w-full h-48 object-cover">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($histories->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $histories->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
