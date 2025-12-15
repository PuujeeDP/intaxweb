{{-- Testimonials Slider Section --}}
@if ($testimonials->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4"> {{ __('frontend.testimonials') }} </h2>
                <p class="text-xl text-gray-600">{{ __('frontend.testimonials_subtitle') }} </p>
            </div>

            {{-- Testimonials Slider with 4 Columns --}}
            <div class="relative" x-data="{
                currentSlide: 0,
                totalSlides: {{ ceil($testimonials->count() / 4) }},
                testimonials: {{ $testimonials->toJson() }},
                itemsPerSlide: 4,
                autoplayInterval: null,
                init() {
                    this.startAutoplay();
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.next();
                    }, 5000);
                },
                stopAutoplay() {
                    if (this.autoplayInterval) {
                        clearInterval(this.autoplayInterval);
                    }
                },
                prev() {
                    this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
                },
                next() {
                    this.currentSlide = this.currentSlide === this.totalSlides - 1 ? 0 : this.currentSlide + 1;
                },
                getVisibleTestimonials() {
                    const start = this.currentSlide * this.itemsPerSlide;
                    return this.testimonials.slice(start, start + this.itemsPerSlide);
                }
            }" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">

                {{-- Testimonials Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <template x-for="(testimonial, index) in getVisibleTestimonials()" :key="testimonial.id">
                        <div class="bg-gray-50 rounded-lg p-6 shadow-md hover:shadow-xl transition duration-300"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100">



                            {{-- Content --}}
                            <p class="text-gray-700 mb-6 line-clamp-4" x-text="testimonial.content"></p>

                            {{-- Rating Stars --}}
                            <div class="flex mb-4">
                                <template x-for="star in 5" :key="star">
                                    <svg :class="star <= testimonial.rating ? 'text-yellow-400' : 'text-gray-300'"
                                        class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>

                            {{-- Client Info --}}
                            <div class="flex items-center">
                                <template x-if="testimonial.client_photo">
                                    <img :src="`/storage/${testimonial.client_photo.file_path}`"
                                        :alt="testimonial.client_name" class="w-12 h-12 rounded-full object-cover mr-4">
                                </template>
                                <template x-if="!testimonial.client_photo">
                                    <div class="w-12 h-12 rounded-full bg-green-600 flex items-center justify-center text-white font-bold mr-4"
                                        x-text="testimonial.client_name.charAt(0).toUpperCase()">
                                    </div>
                                </template>
                                <div>
                                    <p class="font-semibold text-gray-900" x-text="testimonial.client_name"></p>
                                    <template x-if="testimonial.client_position">
                                        <p class="text-sm text-gray-600" x-text="testimonial.client_position"></p>
                                    </template>
                                    <template x-if="testimonial.client_company">
                                        <p class="text-sm text-gray-500" x-text="testimonial.client_company"></p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Navigation Arrows --}}
                <template x-if="totalSlides > 1">
                    <div class="flex justify-center items-center gap-4">
                        <button @click="prev()"
                            class="bg-green-600 hover:bg-green-700 text-white p-3 rounded-full transition shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        {{-- Slide Indicators --}}
                        <div class="flex gap-2">
                            <template x-for="(slide, index) in totalSlides" :key="index">
                                <button @click="currentSlide = index"
                                    :class="currentSlide === index ? 'bg-green-600 w-8' : 'bg-gray-300 w-3'"
                                    class="h-3 rounded-full transition-all duration-300">
                                </button>
                            </template>
                        </div>

                        <button @click="next()"
                            class="bg-green-600 hover:bg-green-700 text-white p-3 rounded-full transition shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </section>
@endif
