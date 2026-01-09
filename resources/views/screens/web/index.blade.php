@extends('layouts.web.app')

@section('content')


@php

// 1. Fetch meta data from CMS table for the 'home' page
    $meta = \App\Models\Cms::with('meta')->where('page', 'home')->get();
    $metaArray = [];

    // 2. Iterate and organize (Your "Memorized" Logic)
    foreach ($meta as $query) {
        foreach ($query->meta as $item) {
            // Check if type matches and organize meta data
            if ($query->type == $item->cms->type) {
                if (!isset($metaArray[$query->type])) {
                    $metaArray[$query->type] = [];
                }
                $metaArray[$query->type][$item->meta_key] = $item;
            }
        }
    }

@endphp

{{-- Hero Section --}}
<section class="bg-white w-full py-16 md:py-24">
  <div class="container mx-auto px-6 md:px-12">

    <div class="flex flex-col md:flex-row items-center justify-center gap-12 lg:gap-20">

      {{-- Hero Book Image --}}
      <div class="w-full md:w-5/12 flex justify-center md:justify-center relative">
        <div class="relative group">
          <img
            src="{{ isset($metaArray['hero-section']['heroBookImage']->meta_value)
                    ? asset('storage/' . $metaArray['hero-section']['heroBookImage']->meta_value)
                    : '' }}"
            alt="{{ $metaArray['hero-section']['heroTitle']->meta_value ?? '' }}"
            class="w-[280px] md:w-[360px] h-auto rounded-sm shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.3)] transform transition-transform duration-500 group-hover:scale-[1.02]"
          >
        </div>
      </div>

      <div class="w-full md:w-7/12 flex flex-col items-center md:items-start text-center md:text-left space-y-6">

        {{-- Hero Category --}}
        <span class="text-xs font-bold tracking-[0.2em] text-gray-500 uppercase font-[Poppins]">
          {{ $metaArray['hero-section']['heroCategory']->meta_value ?? '' }}
        </span>

        {{-- Hero Title --}}
        <h1 class="font-serif font-semibold text-5xl md:text-6xl lg:text-7xl text-[#564744] leading-[1.1]">
           {!! $metaArray['hero-section']['heroTitle']->meta_value ?? '' !!}
        </h1>

        {{-- Hero Description --}}
        <p class="text-gray-600 text-base md:text-lg leading-relaxed max-w-xl font-[Poppins] font-light">
          {!! $metaArray['hero-section']['heroDescription']->meta_value ?? '' !!}
        </p>

        {{-- Hero Button --}}
        <div class="pt-4">
          <a href="{{ $metaArray['hero-section']['heroButtonLink']->meta_value ?? '#' }}"
             class="btn btn-lg rounded-full bg-[#5c4d42] hover:bg-[#42362e] text-white border-none px-10 text-sm tracking-widest uppercase font-bold shadow-lg shadow-[#5c4d42]/30 flex items-center justify-center">
            {{ $metaArray['hero-section']['heroButtonText']->meta_value ?? '' }}
          </a>
        </div>

      </div>

    </div>
  </div>
</section>



@php
    // 1. Decode the images JSON string into an array
    // Notice the key is now 'featured-book-section'
    $bookImages = isset($metaArray['featured-book-section']['featuredBookImages']->meta_value)
        ? json_decode($metaArray['featured-book-section']['featuredBookImages']->meta_value, true)
        : [];

    // 2. Fallback if no images found
    if (empty($bookImages)) {
        $bookImages = [];
    }
@endphp

<section class="bg-[#F8F7F5] py-12 px-4 sm:px-6 lg:px-8 lg:py-20 antialiased font-serif">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-16 items-start">

        {{-- Image Gallery Column --}}
        <div class="lg:col-span-1 flex flex-col gap-5">

            {{-- Main Swiper (PhotoSwipe Container) --}}
            <div wire:ignore id="book-gallery" class="swiper mySwiper2 w-full rounded-lg overflow-hidden bg-white relative border border-neutral-100 cursor-zoom-in">
                <div class="swiper-wrapper">
                    @forelse($bookImages as $img)
                        {{-- Dynamic Slide --}}
                        <div class="swiper-slide bg-white flex justify-center items-center p-2">
                            <a href="{{ asset('storage/' . $img) }}"
                               data-pswp-width="1000"
                               data-pswp-height="1200"
                               target="_blank"
                               class="flex items-center justify-center w-full">
                                <img src="{{ asset('storage/' . $img) }}"
                                     class="w-full h-auto max-h-[280px] object-contain"
                                     alt="Book Image {{ $loop->iteration }}" />
                            </a>
                        </div>
                    @empty
                        {{-- Fallback Slide if No Images --}}
                        <div class="swiper-slide bg-white flex justify-center items-center p-2">
                            <img src="{{ asset('assets/web/images/books/Book_Mockup_3.jpg') }}"
                                 class="w-full h-auto max-h-[280px] object-contain"
                                 alt="Placeholder Book Cover" />
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Thumbnails Swiper --}}
            <div wire:ignore thumbsSlider="" class="swiper mySwiper w-full max-w-xs mx-auto mt-2">
                <div class="swiper-wrapper flex justify-center">
                    @forelse($bookImages as $img)
                        <div class="swiper-slide cursor-pointer opacity-60 transition-opacity hover:opacity-100 rounded-md overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#433328] swiper-slide-thumb-active:opacity-100">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-20 object-contain bg-white" alt="Thumb {{ $loop->iteration }}" />
                        </div>
                    @empty
                        {{-- Fallback Thumb --}}
                        <div class="swiper-slide cursor-pointer opacity-60 transition-opacity hover:opacity-100 rounded-md overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#433328] swiper-slide-thumb-active:opacity-100">
                            <img src="{{ asset('assets/web/images/books/Book_Mockup_3.jpg') }}" class="w-full h-20 object-contain bg-white" alt="Thumb Placeholder" />
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-2 border-t border-neutral-200 pt-5">
                {{-- Category --}}
                <p class="text-xs text-neutral-500 uppercase font-[Poppins] tracking-wide font-semibold">
                    {{ $metaArray['featured-book-section']['featuredCategory']->meta_value ?? '' }}
                </p>

                {{-- Title (Small Left) --}}
                <h2 class="text-lg font-bold font-[Poppins] text-[#433328] mt-1">
                    {{ $metaArray['featured-book-section']['featuredTitle']->meta_value ?? '' }}
                </h2>

                {{-- Prices --}}
                <div class="flex items-center gap-2 mt-2">
                    @if(isset($metaArray['featured-book-section']['featuredDiscountPrice']->meta_value))
                        <span class="text-2xl font-semibold font-[Poppins] text-[#433328]">
                            ${{ $metaArray['featured-book-section']['featuredDiscountPrice']->meta_value }}
                        </span>
                    @endif

                    @if(isset($metaArray['featured-book-section']['featuredPrice']->meta_value))
                        <del class="text-base text-neutral-400 font-[Poppins] font-medium">
                            ${{ $metaArray['featured-book-section']['featuredPrice']->meta_value }}
                        </del>
                    @endif
                </div>

                {{-- Author Info --}}
                <div class="mt-4 flex flex-row items-center justify-between sm:justify-start sm:gap-8">
                    <div class="flex items-center gap-2">
                        @if(isset($metaArray['featured-book-section']['featuredAuthorAvatar']->meta_value))
                            <div class="avatar">
                                <div class="w-8 h-8 rounded-full ring ring-neutral-200 ring-offset-base-100 ring-offset-1">
                                    <img src="{{ asset('storage/' . $metaArray['featured-book-section']['featuredAuthorAvatar']->meta_value) }}"
                                         alt="Author Avatar" />
                                </div>
                            </div>
                        @endif
                        <span class="font-[Poppins] font-semibold text-sm text-neutral-600">
                            {{ $metaArray['featured-book-section']['featuredAuthorName']->meta_value ?? '' }}
                        </span>
                    </div>

                    {{-- Ratings --}}
                    @php
                        $rating = (int) ($metaArray['featured-book-section']['featuredBookRating']->meta_value ?? 0);
                    @endphp
                    @if($rating > 0)
                    <div class="flex items-center gap-0.5 text-[#ff6b00]">
                        @for($i = 0; $i < $rating; $i++)
                            <i class="ri-star-fill text-lg"></i>
                        @endfor
                    </div>
                    @endif
                </div>

                {{-- Button --}}
                <div class="flex flex-col sm:flex-row gap-4 mt-8 w-full">
                    <a href="{{ $metaArray['featured-book-section']['featuredBtn1Link']->meta_value ?? '#' }}"
                       class="btn bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full h-12 px-8 text-xs sm:text-sm font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 w-full sm:w-auto sm:flex-1 flex items-center justify-center">
                        {{ $metaArray['featured-book-section']['featuredBtn1Text']->meta_value ?? 'Buy Now' }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Content Column --}}
        <div class="lg:col-span-2 flex flex-col pt-2">
            {{-- Right Heading --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-[#433328] leading-tight">
                {!! $metaArray['featured-book-section']['featuredRightHeading']->meta_value ?? '' !!}
            </h1>

            {{-- Right Summary / Description --}}
            <div class="mt-8 space-y-6 text-xl font-[Poppins] text-neutral-700 leading-relaxed">
                {!! $metaArray['featured-book-section']['featuredRightSummary']->meta_value ?? '' !!}
            </div>
        </div>

    </div>
</section>


<section class="bg-white py-16 px-4">
  <div class="max-w-5xl mx-auto">

    {{-- Heading --}}
    <h2 class="text-4xl font-medium text-center text-[#000] mb-12 font-[Poppins]">
      {{ $metaArray['about-section']['aboutHeading']->meta_value ?? 'About' }}
    </h2>

    <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">
      <div class="relative shrink-0">
        <div class="rounded-xl border-[5px] border-[#4a3228] bg-white p-[3px] shadow-lg">
          <div class="relative h-72 w-72 sm:h-[320px] sm:w-[320px] rounded-lg overflow-hidden border-2 border-white z-0">

            {{-- Author Image --}}
            <img
              src="{{ isset($metaArray['about-section']['aboutImage']->meta_value)
                      ? asset('storage/' . $metaArray['about-section']['aboutImage']->meta_value)
                      : asset('assets/web/images/gallery/IMG_5941.PNG') }}"
              alt="{{ $metaArray['about-section']['aboutHeading']->meta_value ?? 'Rima Girnius' }}"
              class="w-full h-full object-cover"
            >

          </div>
        </div>
      </div>

      {{-- Description (Rich Text) --}}
      <div class="flex-1 text-lg sm:text-xl text-black italic space-y-6 leading-relaxed font-[Poppins] text-center font-normal md:text-left">
        {!! $metaArray['about-section']['aboutDescription']->meta_value ?? '' !!}
      </div>

    </div>
  </div>
</section>


@php
    // 1. Fetch Heading
    $galleryHeading = $metaArray['author-gallery-section']['galleryHeading']->meta_value ?? 'Author Gallery';

    // 2. Fetch and Decode Images
    $galleryImagesJson = $metaArray['author-gallery-section']['galleryImages']->meta_value ?? '[]';
    $cmsImages = json_decode($galleryImagesJson, true);

    // 3. Define Fallback Static Images (from your HTML)
    $staticImages = [
        'assets/web/images/gallery/IMG_5921.jpg',
        'assets/web/images/gallery/IMG_5935.PNG',
        'assets/web/images/gallery/IMG_5920.jpg',
        'assets/web/images/gallery/IMG_5941.PNG', // This one had z-0 relative in your code, see note below
        'assets/web/images/gallery/IMG_5923 (1).PNG',
        'assets/web/images/gallery/IMG_5922 (1).PNG',
    ];

    // 4. Determine which source to use
    if (!empty($cmsImages) && is_array($cmsImages)) {
        $imagesToDisplay = $cmsImages;
        $isCmsSource = true;
    } else {
        $imagesToDisplay = $staticImages;
        $isCmsSource = false;
    }
@endphp

<section class="bg-[#F8F7F5] py-16 px-4 font-serif">
  <div class="max-w-6xl mx-auto">

    {{-- Heading --}}
    <h2 class="text-4xl font-medium font-[Poppins] text-center text-[#000] mb-12">
      {{ $galleryHeading }}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 px-2 sm:px-0">

      @foreach($imagesToDisplay as $img)
          <div class="bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgb(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgb(0,0,0,0.25)]">
            <div class="aspect-[4/5] w-full overflow-hidden relative">
              <img
                src="{{ asset($isCmsSource ? 'storage/' . $img : $img) }}"
                alt="Author Photo {{ $loop->iteration }}"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500 relative z-0"
              >
            </div>
          </div>
      @endforeach

    </div>
  </div>
</section>

<section class="bg-white py-16 px-4 ">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-[Poppins] font-medium text-center text-black mb-12 tracking-tight">
      Our Latest Blogs
    </h2>

    <div class="grid grid-cols-1 grid-[Poppins] md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

@forelse($posts as $post)
    <article class="bg-[#F5F5F5] p-5 rounded-xl transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg flex flex-col h-full">

        {{-- Image Container --}}
        <div class="bg-[#333333] w-full h-52 rounded-lg mb-5 overflow-hidden group relative">
            {{-- Added w-full, h-full, and object-cover to make the image fill the box perfectly --}}
            <img src="{{ asset('storage/' . $post->image) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
        </div>

        <div class="flex flex-col flex-grow">
            {{-- Date --}}
            <time datetime="{{ $post->created_at->format('Y-m-d') }}" class="text-xs text-gray-500 font-medium mb-2 block font-sans">
                {{ $post->created_at->format('M d, Y') }}
            </time>

            {{-- Title --}}
            <h3 class="text-sm font-[Poppins] text-gray-900 mb-6 font-medium line-clamp-2">
                {{ $post->title }}
            </h3>

            {{-- Read More Link --}}
            <div class="mt-auto">
                <a href="{{ route('blogs.show', $post->id) }}" wire:navigate class="text-sm font-[Poppins] text-gray-500 hover:text-gray-900 transition-colors inline-flex items-center gap-1 font-regular uppercase tracking-wide">
                    Read More
                </a>
            </div>
        </div>
    </article>

@empty
    <div class="col-span-full text-center py-10">
        <p class="text-gray-500">No blog posts found.</p>
    </div>
@endforelse
            {{-- <article class="bg-[#F5F5F5] p-5 rounded-xl transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
        <div class="bg-[#333333] w-full h-52 rounded-lg flex items-center justify-center mb-5 overflow-hidden">
          <span class="text-white text-lg font-medium tracking-wide">Image</span>
        </div>

        <div class="flex flex-col">
          <time datetime="2025-12-10" class="text-xs text-gray-500 font-medium mb-2 block">
            Dec 10, 2025
          </time>

          <h3 class="text-sm font-[Poppins] text-gray-900 mb-6 font-medium">
            Lorem Ipsum is simply dummy text
          </h3>

          <a href="#" class="text-sm font-regular text-gray-500 hover:text-gray-900 transition-colors inline-flex items-center gap-1">
            Read More
          </a>
        </div>
      </article> --}}



            {{-- <article class="bg-[#F5F5F5] p-5 rounded-xl transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
        <div class="bg-[#333333] w-full h-52 rounded-lg flex items-center justify-center mb-5 overflow-hidden">
          <span class="text-white text-lg font-medium tracking-wide">Image</span>
        </div>

        <div class="flex flex-col">
          <time datetime="2025-12-10" class="text-xs text-gray-500 font-medium mb-2 block">
            Dec 10, 2025
          </time>

          <h3 class="text-sm font-[Poppins] text-gray-900 mb-6 font-medium">
            Lorem Ipsum is simply dummy text
          </h3>

          <a href="#" class="text-sm font-regular text-gray-500 hover:text-gray-900 transition-colors inline-flex items-center gap-1">
            Read More
          </a>
        </div>
      </article> --}}

    </div>
  </div>
</section>

@endsection


@push('scripts')
{{-- Load CSS for PhotoSwipe (Ensure this is loaded) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe.min.css">

<script type="module">
    import PhotoSwipeLightbox from 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe-lightbox.esm.min.js';
    import PhotoSwipe from 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe.esm.min.js';

    // 1. Define a global store to track instances across Livewire navigations
    window.galleryStore = window.galleryStore || {
        main: null,
        thumbs: null,
        lightbox: null
    };

    window.initBookGallery = function() {
        const galleryEl = document.getElementById('book-gallery');
        const thumbsEl = document.querySelector('.mySwiper');

        // Safety check: If elements aren't on this page, stop.
        if (!galleryEl || !thumbsEl) return;

        // 2. NUCLEAR CLEANUP: Destroy any existing instances on these specific elements
        // Check if Swiper is attached to the DOM element and destroy it
        if (galleryEl.swiper) galleryEl.swiper.destroy(true, true);
        if (thumbsEl.swiper) thumbsEl.swiper.destroy(true, true);

        // Also destroy our tracked references
        if (window.galleryStore.lightbox) {
            window.galleryStore.lightbox.destroy();
            window.galleryStore.lightbox = null;
        }

        // 3. Initialize Thumbs Swiper
        const thumbSwiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesProgress: true,
            observer: true,       // CRITICAL for Livewire
            observeParents: true, // CRITICAL for Livewire
        });

        // 4. Initialize Main Swiper
        const mainSwiper = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbSwiper,
            },
            observer: true,       // CRITICAL for Livewire
            observeParents: true, // CRITICAL for Livewire
        });

        // 5. Initialize PhotoSwipe
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#book-gallery',
            children: 'a',
            pswpModule: PhotoSwipe,
            initialZoomLevel: 'fit',
            secondaryZoomLevel: 2,
            maxZoomLevel: 4,
        });

        lightbox.init();

        // Save references globally
        window.galleryStore.main = mainSwiper;
        window.galleryStore.thumbs = thumbSwiper;
        window.galleryStore.lightbox = lightbox;

        console.log('Gallery Initialized');
    }

    // 6. Event Listeners for Livewire
    // Run immediately if DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', window.initBookGallery);
    } else {
        window.initBookGallery();
    }

    // Run specifically after Livewire swaps the page
    document.addEventListener('livewire:navigated', () => {
        // Small delay to ensure the new HTML is painted
        setTimeout(window.initBookGallery, 50);
    });
</script>
@endpush
