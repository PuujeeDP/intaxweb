{{-- Testimonials Section - Modern Card Design --}}
@if ($testimonials->count() > 0)
    <section class="py-20 lg:py-28 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
        {{-- Background decoration --}}
        <div class="absolute top-0 left-0 w-72 h-72 bg-red-100 rounded-full opacity-30 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-red-50 rounded-full opacity-40 translate-x-1/3 translate-y-1/3"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-5" style="font-family: 'Open Sans', sans-serif;">
                    {{ __('frontend.testimonials') ?? 'Харилцагчийн сэтгэгдэл' }}
                </h2>
                <p class="text-gray-600">
                    {{ __('frontend.testimonials_subtitle') ?? 'Манай үйлчлүүлэгчид бидний тухай юу хэлж байна' }}
                </p>
            </div>

            {{-- Testimonials Slider --}}
            <div class="relative" x-data="{
                currentSlide: 0,
                totalSlides: {{ ceil($testimonials->count() / 3) }},
                testimonials: {{ $testimonials->toJson() }},
                itemsPerSlide: 3,
                autoplayInterval: null,
                init() {
                    this.startAutoplay();
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.next();
                    }, 6000);
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

                {{-- Navigation Arrows on Sides --}}
                <template x-if="totalSlides > 1">
                    <button @click="prev()"
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-12 lg:-translate-x-16 z-10 w-12 h-12 rounded-full flex items-center justify-center bg-gray-200 transition-all duration-300 hover:scale-110 shadow-lg"
                        style="--tw-bg-opacity: 1;"
                        onmouseenter="this.style.background='linear-gradient(135deg, #d40c19 0%, #C41820 100%)'; this.querySelector('svg').style.stroke='white'"
                        onmouseleave="this.style.background='rgb(229 231 235)'; this.querySelector('svg').style.stroke='rgb(156 163 175)'">
                        <svg class="w-5 h-5" fill="none" stroke="rgb(156 163 175)" viewBox="0 0 24 24" style="transition: stroke 0.3s">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                </template>

                <template x-if="totalSlides > 1">
                    <button @click="next()"
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-12 lg:translate-x-16 z-10 w-12 h-12 rounded-full flex items-center justify-center bg-gray-200 transition-all duration-300 hover:scale-110 shadow-lg"
                        style="--tw-bg-opacity: 1;"
                        onmouseenter="this.style.background='linear-gradient(135deg, #d40c19 0%, #C41820 100%)'; this.querySelector('svg').style.stroke='white'"
                        onmouseleave="this.style.background='rgb(229 231 235)'; this.querySelector('svg').style.stroke='rgb(156 163 175)'">
                        <svg class="w-5 h-5" fill="none" stroke="rgb(156 163 175)" viewBox="0 0 24 24" style="transition: stroke 0.3s">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </template>

                {{-- Testimonials Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <template x-for="(testimonial, index) in getVisibleTestimonials()" :key="testimonial.id">
                        <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0">

                            {{-- Quote Icon --}}
                            <div class="absolute -top-4 left-8">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Rating Stars --}}
                            <div class="flex gap-1 mb-6 pt-4">
                                <template x-for="star in 5" :key="star">
                                    <svg :class="star <= testimonial.rating ? 'text-yellow-400' : 'text-gray-200'"
                                        class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </template>
                            </div>

                            {{-- Content --}}
                            <p class="text-gray-600 leading-relaxed mb-8 line-clamp-4" x-text="testimonial.content"></p>

                            {{-- Client Info --}}
                            <div class="flex items-center pt-6 border-t border-gray-100">
                                <template x-if="testimonial.client_photo">
                                    <img :src="`/storage/${testimonial.client_photo.file_path}`"
                                        :alt="testimonial.client_name"
                                        class="w-14 h-14 rounded-full object-cover ring-4 ring-red-50 mr-4">
                                </template>
                                <template x-if="!testimonial.client_photo">
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 ring-4 ring-red-50"
                                        style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%);"
                                        x-text="testimonial.client_name.charAt(0).toUpperCase()">
                                    </div>
                                </template>
                                <div>
                                    <p class="font-bold text-gray-900" x-text="testimonial.client_name"></p>
                                    <template x-if="testimonial.client_position || testimonial.client_company">
                                        <p class="text-sm text-gray-500">
                                            <span x-text="testimonial.client_position"></span>
                                            <template x-if="testimonial.client_position && testimonial.client_company">
                                                <span>, </span>
                                            </template>
                                            <span x-text="testimonial.client_company" class="text-[#d40c19]"></span>
                                        </p>
                                    </template>
                                </div>
                            </div>

                            {{-- Hover accent line --}}
                            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"
                                style="background: linear-gradient(135deg, #d40c19 0%, #C41820 100%);"></div>
                        </div>
                    </template>
                </div>

            </div>
        </div>
    </section>
@endif
