@extends('layouts.web.app')

@section('content')
<section class="bg-white w-full py-16 md:py-24">
  <div class="container mx-auto px-6 md:px-12">

    <div class="flex flex-col md:flex-row items-center justify-center gap-12 lg:gap-20">

      <div class="w-full md:w-5/12 flex justify-center md:justify-center relative">
        <div class="relative group">
          <img
            src="{{ asset('assets/web/images/books/eureka-book.jpg') }}"
            alt="Eureka and The Magical Trio Book Cover"
            class="w-[280px] md:w-[360px] h-auto rounded-sm shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.3)] transform transition-transform duration-500 group-hover:scale-[1.02]"
          >
        </div>
      </div>

      <div class="w-full md:w-7/12 flex flex-col items-center md:items-start text-center md:text-left space-y-6">

        <span class="text-xs font-bold tracking-[0.2em] text-gray-500 uppercase font-[Poppins]">
          Geography & Cultures
        </span>

        <h1 class="font-times font-semibold text-5xl md:text-6xl lg:text-7xl text-[#564744] leading-[1.1]">
          Discover the Magic <br>
          of Who You <br>
          Truly Are
        </h1>

        <p class="text-gray-600 text-base md:text-lg leading-relaxed max-w-xl font-[Poppins] font-light">
          Discover <span class="italic">Eureka and the Magical Trio</span>: The enchanting new novel by Lithuanian American writer Rima Girnius that celebrates heritage, self discovery, and the powerful bond in an immigrant mother daughter story.
        </p>

        <div class="pt-4">
          <button class="btn btn-lg rounded-full bg-[#5c4d42] hover:bg-[#42362e] text-white border-none px-10 text-sm tracking-widest uppercase font-bold shadow-lg shadow-[#5c4d42]/30">
            Order Your Copy Now
          </button>
        </div>

      </div>

    </div>
  </div>
</section>

<section class="bg-[#F8F7F5] py-12 px-4 sm:px-6 lg:px-8 lg:py-20 antialiased font-serif">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-16 items-start">

    <div class="lg:col-span-1 flex flex-col gap-5">
      <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 w-full rounded-lg overflow-hidden bg-white relative border border-neutral-100">
        <div class="swiper-wrapper">
          <div class="swiper-slide bg-white flex justify-center items-center p-2">
            <img src="{{ asset('assets/web/images/books/Book_Mockup_3.jpg') }}" class="w-full h-auto object-contain max-h-[280px]" alt="Book Cover" />
          </div>
          <div class="swiper-slide bg-white flex justify-center items-center p-2">
             <img src="{{ asset('assets/web/images/books/eureka-book.jpg') }}" class="w-full h-auto object-contain max-h-[280px]" alt="Side View" />
          </div>
           <div class="swiper-slide bg-white flex justify-center items-center p-2">
             <img src="{{ asset('assets/web/images/books/back-eureka-book.png') }}" class="w-full h-auto object-contain max-h-[280px]" alt="Back View" />
          </div>
        </div>
      </div>

      <div thumbsSlider="" class="swiper mySwiper w-full max-w-xs mx-auto">
        <div class="swiper-wrapper flex justify-center">
          <div class="swiper-slide w-1/4 cursor-pointer opacity-60 transition-opacity hover:opacity-100 rounded-md overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#433328] swiper-slide-thumb-active:opacity-100">
            <img src="{{ asset('assets/web/images/books/Book_Mockup_3.jpg') }}" class="w-full h-28 object-cover" alt="Thumb 1" />
          </div>
          <div class="swiper-slide w-1/4 cursor-pointer opacity-60 transition-opacity hover:opacity-100 rounded-md overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#433328] swiper-slide-thumb-active:opacity-100">
            <img src="{{ asset('assets/web/images/books/eureka-book.jpg') }}" class="w-full h-28 object-cover" alt="Thumb 2" />
          </div>
          <div class="swiper-slide w-1/4 cursor-pointer opacity-60 transition-opacity hover:opacity-100 rounded-md overflow-hidden border-2 border-transparent swiper-slide-thumb-active:border-[#433328] swiper-slide-thumb-active:opacity-100">
            <img src="{{ asset('assets/web/images/books/back-eureka-book.png') }}" class="w-full h-28 object-cover" alt="Thumb 3" />
          </div>
        </div>
      </div>

      <div class="mt-2 border-t border-neutral-200 pt-5">
        <p class="text-xs text-neutral-500 uppercase tracking-wide font-semibold">Geography & Cultures</p>
        <h2 class="text-lg font-bold text-[#433328] mt-1">Eureka and the magical trio</h2>

        <div class="flex items-center gap-2 mt-2">
          <span class="text-2xl font-bold text-[#433328]">$30.00</span>
          <del class="text-base text-neutral-400 font-medium">$39.00</del>
        </div>

        <div class="mt-4 flex flex-row items-center justify-between sm:justify-start sm:gap-8">
          <div class="flex items-center gap-2">
            <div class="avatar">
              <div class="w-8 h-8 rounded-full ring ring-neutral-200 ring-offset-base-100 ring-offset-1">
                <img src="https://placehold.co/100x100/433328/FFF?text=RG" alt="Rima Marija Girnius" />
              </div>
            </div>
            <span class="font-bold text-sm text-neutral-600">Rima Marija Girnius</span>
          </div>

          <div class="flex items-center gap-0.5 text-[#ff6b00]">
            <i class="ri-star-fill text-lg"></i>
            <i class="ri-star-fill text-lg"></i>
            <i class="ri-star-fill text-lg"></i>
            <i class="ri-star-fill text-lg"></i>
            <i class="ri-star-fill text-lg"></i>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mt-8 w-full">
            <button class="btn bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full h-12 px-8 text-xs sm:text-sm font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 w-full sm:w-auto sm:flex-1">
                Buy Now
            </button>
            <button class="btn btn-outline bg-transparent border-2 border-[#5C4B43] text-[#5C4B43] hover:bg-[#5C4B43] hover:text-white hover:border-[#5C4B43] rounded-full h-12 px-8 text-xs sm:text-sm font-bold uppercase tracking-widest shadow-sm hover:shadow-xl transition-all transform hover:-translate-y-0.5 w-full sm:w-auto sm:flex-1 whitespace-nowrap">
                Amazon Kindle
            </button>
        </div>

      </div>
    </div>

    <div class="lg:col-span-2 flex flex-col pt-2">
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-[#433328] leading-tight">
        Eureka And The Magical Trio
      </h1>

      <div class="mt-8 space-y-6 text-xl font-[Poppins] text-neutral-700 leading-relaxed">
        <p class="italic font-regular text-xl text-[#5C4B43]">
          Dive into a beautifully woven tale of cultural identity in this YA novel.
        </p>
        <p>
          Set in Quincy, Massachusetts, the story follows Eureka, a Lithuanian American teen struggling to find her place in the world. Guided by her mother’s wisdom and the extraordinary “Magical Trio” (a kaleidoscope, a mandala, and her eyeglasses), Eureka embarks on a metaphysical journey through breathtaking landscapes inspired by the Lithuanian genius Čiurlionis.
        </p>
        <p>
          This captivating blend of magical realism explores universal themes of nationality, ethnicity, and language, making it a must-read for families, educators, and anyone seeking a powerful story of self-acceptance and heritage.
        </p>
      </div>
    </div>

  </div>
</section>

<section class="bg-white py-16 px-4">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-4xl font-medium text-center text-[#000] mb-12 font-[Poppins]">
      About the Author
    </h2>

    <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">
      <div class="relative shrink-0">
        <div class="rounded-xl border-[5px] border-[#4a3228] bg-white p-[3px] shadow-lg">
          <div class="relative h-72 w-72 sm:h-[320px] sm:w-[320px] rounded-lg overflow-hidden border-2 border-white z-0">
            <img
              src="{{ asset('assets/web/images/gallery/IMG_5941.PNG') }}"
              alt="Rima Girnius"
              class="w-full h-full object-cover"
            >
            <!-- <img
              src=""
              alt="Sparkles"
              class="absolute inset-0 w-full h-full object-cover pointer-events-none opacity-60 mix-blend-screen z-10"
            > -->
          </div>
        </div>
      </div>

      <div class="flex-1 text-lg sm:text-xl text-black italic space-y-6 leading-relaxed font-[Poppins] text-center font-normal md:text-left">
        <p>
          Rima Girnius is a Lithuanian born American writer, former Radio journalist, and author of <strong>Eureka And The Magical Trio.</strong>
        </p>
        <p>
          Blending a diverse background in Industrial and Civil Engineering, Journalism and Communications, and Applied Sociology, she earned a Graduate Certificate in Creative Writing from Humber College in Toronto, Canada.
        </p>
        <p>
          She is based in Duxbury, MA, USA.
        </p>
      </div>
    </div>
  </div>
</section>

<section class="bg-[#F8F7F5] py-16 px-4 font-serif">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-4xl font-medium font-[Poppins] text-center text-[#000] mb-12">
      Author Gallery
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 px-2 sm:px-0">

      <div class="bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgb(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgb(0,0,0,0.25)]">
        <div class="aspect-[4/5] w-full overflow-hidden">
          <img src="{{ asset('assets/web/images/gallery/IMG_5921.jpg') }}" alt="Author Photo 1" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <div class="bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgb(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgb(0,0,0,0.25)]">
        <div class="aspect-[4/5] w-full overflow-hidden">
          <img src="{{ asset('assets/web/images/gallery/IMG_5935.PNG') }}" alt="Author Photo 2" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <div class="bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgb(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgb(0,0,0,0.25)]">
        <div class="aspect-[4/5] w-full overflow-hidden">
          <img src="{{ asset('assets/web/images/gallery/IMG_5920.jpg') }}" alt="Author Photo 3" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <div class="bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgb(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgb(0,0,0,0.25)]">
        <div class="aspect-[4/5] w-full overflow-hidden relative">
           <img src="{{ asset('assets/web/images/gallery/IMG_5941.PNG') }}" alt="Author Photo 5" class="w-full h-full object-cover relative z-0">
        </div>
      </div>

      <div class="bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgb(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgb(0,0,0,0.25)]">
        <div class="aspect-[4/5] w-full overflow-hidden">
          <img src="{{ asset('assets/web/images/gallery/IMG_5923 (1).PNG') }}" alt="Author Photo 6" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <div class="bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgb(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgb(0,0,0,0.25)]">
        <div class="aspect-[4/5] w-full overflow-hidden">
          <img src="{{ asset('assets/web/images/gallery/IMG_5922 (1).PNG') }}" alt="Author Photo 7" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
      </div>

    </div>
  </div>
</section>


<section class="bg-white py-16 px-4 ">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-[Poppins] font-medium text-center text-black mb-12 tracking-tight">
      Our Latest Blogs
    </h2>

    <div class="grid grid-cols-1 grid-[Poppins] md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

      <article class="bg-[#F5F5F5] p-5 rounded-xl transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
        <div class="bg-[#333333] w-full h-52 rounded-lg flex items-center justify-center mb-5 overflow-hidden group">
          <span class="text-white text-lg font-medium tracking-wide">Image</span>
          </div>

        <div class="flex flex-col">
          <time datetime="2025-12-10" class="text-xs text-gray-500 font-medium mb-2 block">
            Dec 10, 2025
          </time>

          <h3 class="text-sm font-[Poppins] text-gray-900 mb-6 font-medium ">
            Lorem Ipsum is simply dummy text
          </h3>

          <a href="#" class="text-sm font-[Poppins] text-gray-500 hover:text-gray-900 transition-colors inline-flex items-center gap-1">
            Read More
          </a>
        </div>
      </article>

      <article class="bg-[#F5F5F5] p-5 rounded-xl transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
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
      </article>

      <article class="bg-[#F5F5F5] p-5 rounded-xl transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
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
      </article>

    </div>
  </div>
</section>

@endsection


@push('scripts')
<script>
    function initSwiper() {
        const thumbSwiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbSwiper,
            },
        });
    }

    document.addEventListener('livewire:navigated', () => {
        initSwiper();
    });

    document.addEventListener('DOMContentLoaded', () => {
        initSwiper();
    });
</script>


@endpush
