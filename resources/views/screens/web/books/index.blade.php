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

                {{-- LEFT COLUMN: IMAGES (Target Layout) --}}
                <div class="flex flex-row gap-4 w-full lg:w-auto shrink-0 justify-center h-[400px] sm:h-[500px] lg:h-[550px]"
                     id="books-page-gallery">

                    {{-- 1. MAIN SWIPER (Left Side) --}}
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                         class="swiper booksMainSwiper w-[280px] sm:w-[380px] lg:w-[450px] h-full rounded-sm overflow-hidden bg-[#262626] shadow-xl">

                        <div class="swiper-wrapper h-full">

                            {{-- A. Main Cover Image --}}
                            @if($book->cover_image)
                                <div class="swiper-slide h-full flex justify-center items-center bg-[#262626]">
                                    {{-- Anchor for PhotoSwipe with onload handler to set dimensions --}}
                                    <a href="{{ asset('storage/' . $book->cover_image) }}"
                                       target="_blank"
                                       data-pswp-width=""
                                       data-pswp-height=""
                                       class="h-full w-full flex justify-center items-center pswp-link">
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             class="h-full w-auto object-contain drop-shadow-2xl"
                                             alt="{{ $book->title }} Cover"
                                             onload="this.parentElement.setAttribute('data-pswp-width', this.naturalWidth); this.parentElement.setAttribute('data-pswp-height', this.naturalHeight);" />
                                    </a>
                                </div>
                            @endif

                            {{-- B. Gallery Images --}}
                            @foreach($book->images as $image)
                                <div class="swiper-slide h-full flex justify-center items-center bg-white">
                                    <a href="{{ asset('storage/' . $image->image) }}"
                                       target="_blank"
                                       data-pswp-width=""
                                       data-pswp-height=""
                                       class="h-full w-full flex justify-center items-center pswp-link">
                                        <img src="{{ asset('storage/' . $image->image) }}"
                                             class="h-full w-auto object-contain drop-shadow-2xl"
                                             alt="Gallery Image"
                                             onload="this.parentElement.setAttribute('data-pswp-width', this.naturalWidth); this.parentElement.setAttribute('data-pswp-height', this.naturalHeight);" />
                                    </a>
                                </div>
                            @endforeach

                        </div>

                        <!-- <div class="swiper-button-next"></div> -->
                        <!-- <div class="swiper-button-prev"></div> -->
                    </div>

                    {{-- 2. THUMBS SWIPER (Right Column) --}}
                    <div thumbsSlider="" class="swiper booksThumbSwiper bg-white w-20 sm:w-24 h-full shrink-0">
                        <div class="swiper-wrapper bg-white flex flex-col h-full">

                            {{-- A. Main Cover Thumb --}}
                            @if($book->cover_image)
                                <div class="swiper-slide !h-auto aspect-[3/4] mb-3 cursor-pointer rounded-sm overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#564744] bg-white p-1 flex justify-center items-center transition-all opacity-70 bg-white swiper-slide-thumb-active:opacity-100">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                         class="w-full h-full object-contain" alt="Thumb Cover" />
                                </div>
                            @endif

                            {{-- B. Gallery Thumbs --}}
                            @foreach($book->images as $image)
                                <div class="swiper-slide !h-auto aspect-[3/4] mb-3 cursor-pointer rounded-sm overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#564744] bg-white p-1 flex justify-center items-center transition-all opacity-70 swiper-slide-thumb-active:opacity-100">
                                    <img src="{{ asset('storage/' . $image->image) }}"
                                         class="w-full h-full object-contain" alt="Thumb Gallery" />
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN: DETAILS --}}
                <div class="flex flex-col space-y-5 pt-2 w-full lg:max-w-lg text-center lg:text-left">
                    <span class="text-sm font-bold tracking-widest text-gray-500 uppercase">
                        Geography & Cultures
                    </span>

                    <h2 class="text-3xl sm:text-4xl md:text-[2.75rem] font-[Poppins] font-medium text-black leading-[1.2] tracking-tight">
                        {{ $book->title }}
                    </h2>

                    <div class="flex items-baseline justify-center lg:justify-start gap-3 mt-1">
                        @if($book->sale_price < $book->price)
                            <span class="text-3xl font-extrabold text-[#433328]">${{ $book->sale_price }}</span>
                            <span class="text-2xl text-gray-400 line-through font-bold decoration-[3px]">${{ $book->price }}</span>
                        @else
                            <span class="text-3xl font-extrabold text-[#433328]">${{ $book->price }}</span>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 sm:gap-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                                <img src="{{ asset('assets/web/images/gallery/IMG_5941.PNG') }}"
                                    class="object-cover w-full h-full" alt="Rima Girnius" />
                            </div>
                            <span class="font-medium text-lg text-gray-700 whitespace-nowrap">Rima Girnius</span>
                        </div>
                        <div class="flex items-center text-[#ff6b00] gap-1">
                            @for($i=0; $i<5; $i++) <i class="ri-star-fill text-xl"></i> @endfor
                        </div>
                    </div>


                    <div class="flex flex-col sm:flex-row gap-4 mt-2 w-full">
                        {{-- Update the HREF to point to checkout.index --}}

@if($hasPurchased)
        {{-- OPTION A: DOWNLOAD BUTTON (If purchased) --}}
        <a href="{{ route('books.download', $book->id) }}"
           class="btn bg-green-700 hover:bg-green-800 text-white border-none rounded-full h-14 px-8 text-base font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 w-full sm:flex-1 flex items-center justify-center text-decoration-none">
            <i class="fas fa-download me-2"></i> Download Book
        </a>
    @else
        {{-- OPTION B: BUY BUTTON (If NOT purchased) --}}
        <a href="{{ route('checkout.index', $book->id) }}"
           class="btn bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full h-14 px-8 text-base font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 w-full sm:flex-1 flex items-center justify-center text-decoration-none">
            Buy Now
        </a>
    @endif

                    </div>

            </div>


            </div>
        </div>
    </section>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe.min.css">

<script type="module">
    import PhotoSwipeLightbox from 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe-lightbox.esm.min.js';
    import PhotoSwipe from 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe.esm.min.js';

    window.booksGalleryStore = window.booksGalleryStore || { main: null, thumbs: null, lightbox: null };

    window.initBooksPageGallery = function() {
        const galleryEl = document.getElementById('books-page-gallery');
        const thumbsEl = document.querySelector('.booksThumbSwiper');

        if (!galleryEl || !thumbsEl) return;

        if (galleryEl.swiper) galleryEl.swiper.destroy(true, true);
        if (thumbsEl.swiper) thumbsEl.swiper.destroy(true, true);
        if (window.booksGalleryStore.lightbox) {
            window.booksGalleryStore.lightbox.destroy();
            window.booksGalleryStore.lightbox = null;
        }

        // Thumbs Swiper (Vertical, 3 slides)
        const thumbSwiper = new Swiper(".booksThumbSwiper", {
            direction: 'vertical',
            spaceBetween: 10,
            slidesPerView: 3, // Show 3 thumbs
            freeMode: true,
            watchSlidesProgress: true,
            observer: true,
            observeParents: true,
        });

        // Main Swiper
        const mainSwiper = new Swiper(".booksMainSwiper", {
            spaceBetween: 10,
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            thumbs: { swiper: thumbSwiper },
            observer: true,
            observeParents: true,
        });

        // PhotoSwipe (Targeting .pswp-link)
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#books-page-gallery',
            children: '.pswp-link', // Use the class we added
            pswpModule: PhotoSwipe,
            initialZoomLevel: 'fit',
            secondaryZoomLevel: 2,
            maxZoomLevel: 4,
        });

        lightbox.init();

        window.booksGalleryStore.main = mainSwiper;
        window.booksGalleryStore.thumbs = thumbSwiper;
        window.booksGalleryStore.lightbox = lightbox;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', window.initBooksPageGallery);
    } else {
        window.initBooksPageGallery();
    }

    document.addEventListener('livewire:navigated', () => {
        setTimeout(window.initBooksPageGallery, 50);
    });
</script>
@endpush
