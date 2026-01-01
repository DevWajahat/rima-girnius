@extends('layouts.web.app')

@section('content')

    <section class="bg-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-bold text-[#433328] font-['Times_New_Roman']">
                    Books
                </h1>
            </div>
        </div>
    </section>

    <section class="bg-[#F8F7F5] py-16 md:py-24 antialiased font-['Poppins']">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start justify-center">

                <div class="flex flex-row gap-4 w-full lg:w-auto shrink-0 justify-center h-[400px] sm:h-[500px] lg:h-[550px]">

                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                        class="swiper bookMainSwiper w-[280px] sm:w-[380px] lg:w-[450px] h-full rounded-sm overflow-hidden bg-[#262626] shadow-xl">
                        <div class="swiper-wrapper h-full">

                            <div class="swiper-slide h-full flex justify-center items-center p-4 bg-[#262626]">
                                <img src="{{ asset('assets/web/images/books/Book_Mockup_3.jpg') }}"
                                    class="h-full w-auto object-contain drop-shadow-2xl" alt="Book Cover" />
                            </div>

                            <div class="swiper-slide h-full flex justify-center items-center p-4 bg-[#262626]">
                                <img src="{{ asset('assets/web/images/books/eureka-book.jpg') }}"
                                    class="h-full w-auto object-cover drop-shadow-2xl" alt="Book Angle" />
                            </div>

                            <div class="swiper-slide h-full flex justify-center items-center p-4 bg-[#262626]">
                                <img src="{{ asset('assets/web/images/books/back-eureka-book.png') }}"
                                    class="h-full w-auto object-contain drop-shadow-2xl" alt="Book Back" />
                            </div>

                        </div>
                    </div>

                    <div thumbsSlider="" class="swiper bookThumbSwiper w-20 sm:w-24 h-full shrink-0">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide !h-auto aspect-[3/4] mb-3 cursor-pointer rounded-sm overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#564744] bg-white p-1 flex justify-center items-center transition-all opacity-70 swiper-slide-thumb-active:opacity-100">
                                <img src="{{ asset('assets/web/images/books/Book_Mockup_3.jpg') }}"
                                    class="w-full h-full object-contain" alt="Thumb 1" />
                            </div>

                            <div class="swiper-slide !h-auto aspect-[3/4] mb-3 cursor-pointer rounded-sm overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#564744] bg-white p-1 flex justify-center items-center transition-all opacity-70 swiper-slide-thumb-active:opacity-100">
                                <img src="{{ asset('assets/web/images/books/eureka-book.jpg') }}"
                                    class="w-full h-full object-contain" alt="Thumb 2" />
                            </div>

                            <div class="swiper-slide !h-auto aspect-[3/4] mb-3 cursor-pointer rounded-sm overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#564744] bg-white p-1 flex justify-center items-center transition-all opacity-70 swiper-slide-thumb-active:opacity-100">
                                <img src="{{ asset('assets/web/images/books/back-eureka-book.png') }}"
                                    class="w-full h-full object-contain" alt="Thumb 3" />
                            </div>

                        </div>
                    </div>

                </div>

                <div class="flex flex-col space-y-5 pt-2 w-full lg:max-w-lg text-center lg:text-left">

                    <span class="text-sm font-bold tracking-widest text-gray-500 uppercase">
                        Geography & Cultures
                    </span>

                    <h2 class="text-3xl sm:text-4xl md:text-[2.75rem] font-[Poppins] font-medium text-black leading-[1.2] tracking-tight">
                        Eureka and the magical trio
                    </h2>

                    <div class="flex items-baseline justify-center lg:justify-start gap-3 mt-1">
                        <span class="text-3xl font-extrabold text-[#433328]">$30.00</span>
                        <span class="text-2xl text-gray-400 line-through font-bold decoration-[3px]">$39.00</span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 sm:gap-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                                <img src="{{ asset('assets/web/images/gallery/IMG_5941.PNG') }}"
                                    class="object-cover w-full h-full" alt="Rima Marija Girnius" />
                            </div>
                            <span class="font-medium text-lg text-gray-700 whitespace-nowrap">Rima Marija Girnius</span>
                        </div>

                        <div class="flex items-center text-[#ff6b00] gap-1">
                            <i class="ri-star-fill text-xl"></i>
                            <i class="ri-star-fill text-xl"></i>
                            <i class="ri-star-fill text-xl"></i>
                            <i class="ri-star-fill text-xl"></i>
                            <i class="ri-star-fill text-xl"></i>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 mt-2 w-full">
                        <button class="btn bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full h-14 px-8 text-base font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 w-full sm:flex-1">
                            Buy Now
                        </button>
                        <button class="btn btn-outline bg-transparent border-2 border-[#5C4B43] text-[#5C4B43] hover:bg-[#5C4B43] hover:text-white hover:border-[#5C4B43] rounded-full h-14 px-8 text-base font-bold uppercase tracking-widest shadow-sm hover:shadow-xl transition-all transform hover:-translate-y-0.5 w-full sm:flex-1 whitespace-nowrap">
                            Amazon Kindle
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <script>
        function initBookSwiper() {
            // Check if element exists to avoid console errors
            if(!document.querySelector('.bookThumbSwiper')) return;

            var bookThumbSwiper = new Swiper(".bookThumbSwiper", {
                direction: 'vertical',
                spaceBetween: 12,
                slidesPerView: 'auto',
                freeMode: true,
                watchSlidesProgress: true,
            });

            var bookMainSwiper = new Swiper(".bookMainSwiper", {
                spaceBetween: 10,
                thumbs: {
                    swiper: bookThumbSwiper,
                },
            });
        }

        document.addEventListener('DOMContentLoaded', initBookSwiper);
        document.addEventListener('livewire:navigated', initBookSwiper);
    </script>

@endsection
