@extends('layouts.web.app')

@section('content')
    <section class="bg-[#F5F5F5] py-16 px-4 min-h-screen font-[Poppins] text-gray-900">
        <div class="max-w-7xl mx-auto">

            <div class="mb-12 text-center">
                <h1 class="text-3xl md:text-4xl font-[Poppins] font-semibold text-center text-[#000] mb-4 tracking-tight">
                    The Archive
                </h1>
                <div class="w-32 h-1 bg-[#5c4d42] mx-auto rounded-full"></div>
            </div>

            <div class="relative mb-16 px-0 md:px-10">
                <div class="swiper featuredSwiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide py-4 px-2">
                            <div class="bg-white shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.1)] rounded-md p-6 flex flex-col lg:flex-row gap-8 items-center border border-gray-100">
                                <div class="w-full lg:w-1/2 relative group">
                                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox" data-title="Deep Space Lore: Origin of Galaxies">
                                        <img src="https://images.unsplash.com/photo-1462331940025-496dfbfc7564?q=80&w=800" alt="Featured Thumbnail" class="w-full h-auto aspect-video object-cover rounded-sm shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.3)] transform transition-transform duration-500 group-hover:scale-[1.02]">
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="bg-[#2196F3] text-white rounded-full p-4 group-hover:scale-110 transition-transform shadow-lg shadow-[#2196F3]/40">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="w-full lg:w-1/2 flex flex-col gap-4 items-center md:items-start text-center md:text-left">
                                    <span class="text-xs font-bold tracking-[0.2em] text-gray-500 uppercase font-[Poppins]">
                                        Featured Video
                                    </span>
                                    <h2 class="font-serif font-semibold text-3xl md:text-4xl text-[#564744] leading-[1.1]">Deep Space Lore: Origin of Galaxies</h2>
                                    <p class="text-gray-600 text-base md:text-lg leading-relaxed max-w-xl font-[Poppins] font-light">Explore the cosmos in this curated collection. Discover the vastness of space and the origin stories of our universe.</p>
                                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox flex items-center justify-center rounded-full bg-[#5c4d42] hover:bg-[#42362e] text-white border-none px-10 py-3 text-sm tracking-widest uppercase font-bold shadow-lg shadow-[#5c4d42]/30 transition-colors">Watch Video</a>
                                        <button class="flex items-center justify-center bg-transparent border-2 border-[#5c4d42] hover:bg-[#5c4d42] hover:text-white text-[#5c4d42] px-10 py-3 rounded-full uppercase tracking-widest font-bold text-sm transition-colors">Explore Collection</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide py-4 px-2">
                            <div class="bg-white shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.1)] rounded-md p-6 flex flex-col lg:flex-row gap-8 items-center border border-gray-100">
                                <div class="w-full lg:w-1/2 relative group">
                                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox" data-title="Mythology Explained">
                                        <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=800" alt="Featured Thumbnail" class="w-full h-auto aspect-video object-cover rounded-sm shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.3)] transform transition-transform duration-500 group-hover:scale-[1.02]">
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="bg-[#2196F3] text-white rounded-full p-4 group-hover:scale-110 transition-transform shadow-lg shadow-[#2196F3]/40">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="w-full lg:w-1/2 flex flex-col gap-4 items-center md:items-start text-center md:text-left">
                                    <span class="text-xs font-bold tracking-[0.2em] text-gray-500 uppercase font-[Poppins]">
                                        Author Spotlight
                                    </span>
                                    <h2 class="font-serif font-semibold text-3xl md:text-4xl text-[#564744] leading-[1.1]">The Origins of Ancient Myths</h2>
                                    <p class="text-gray-600 text-base md:text-lg leading-relaxed max-w-xl font-[Poppins] font-light">Dive into the historical texts that shaped modern storytelling. Uncover the secrets hidden within classic mythology.</p>
                                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox flex items-center justify-center rounded-full bg-[#5c4d42] hover:bg-[#42362e] text-white border-none px-10 py-3 text-sm tracking-widest uppercase font-bold shadow-lg shadow-[#5c4d42]/30 transition-colors">Watch Video</a>
                                        <button class="flex items-center justify-center bg-transparent border-2 border-[#5c4d42] hover:bg-[#5c4d42] hover:text-white text-[#5c4d42] px-10 py-3 rounded-full uppercase tracking-widest font-bold text-sm transition-colors">Explore Collection</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="swiper-button-next featured-next !text-[#5c4d42] !right-0 font-bold scale-75"></div>
                <div class="swiper-button-prev featured-prev !text-[#5c4d42] !left-0 font-bold scale-75"></div>
            </div>

            <section class="mb-16 min-h-[300px]">

                <div class="category-carousel block relative px-8" data-index="0">
                    <div class="swiper archiveSwiper">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox block relative group" data-title="Star Birth">
                                    <img src="https://images.unsplash.com/photo-1462331940025-496dfbfc7564?q=80&w=400" alt="Video Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="bg-[#2196F3] text-white rounded-full p-2 group-hover:scale-110 transition-transform shadow-lg shadow-[#2196F3]/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="swiper-slide">
                                <a href="https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3?q=80&w=800" class="glightbox block relative group" data-title="Galactic Core">
                                    <img src="https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3?q=80&w=400" alt="Image Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                </a>
                            </div>

                            <div class="swiper-slide">
                                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox block relative group" data-title="Deep Field View">
                                    <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=400" alt="Video Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="bg-[#2196F3] text-white rounded-full p-2 group-hover:scale-110 transition-transform shadow-lg shadow-[#2196F3]/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="swiper-slide">
                                <a href="https://images.unsplash.com/photo-1464802686167-b939a6910659?q=80&w=800" class="glightbox block relative group" data-title="Planetary Orbits">
                                    <img src="https://images.unsplash.com/photo-1464802686167-b939a6910659?q=80&w=400" alt="Image Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="swiper-button-next !text-[#5c4d42] !right-0 font-bold scale-75"></div>
                    <div class="swiper-button-prev !text-[#5c4d42] !left-0 font-bold scale-75"></div>
                </div>

                <div class="category-carousel hidden relative px-8" data-index="1">
                    <div class="swiper archiveSwiper">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <a href="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=800" class="glightbox block relative group" data-title="Ancient Tomes">
                                    <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=400" alt="Image Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                </a>
                            </div>

                            <div class="swiper-slide">
                                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox block relative group" data-title="Olympian Tales">
                                    <img src="https://images.unsplash.com/photo-1589998059171-989d887dda19?q=80&w=400" alt="Video Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="bg-[#2196F3] text-white rounded-full p-2 group-hover:scale-110 transition-transform shadow-lg shadow-[#2196F3]/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="swiper-slide">
                                <a href="https://images.unsplash.com/photo-1474366521946-c3d4b507abf2?q=80&w=800" class="glightbox block relative group" data-title="Chapter 1 Reading">
                                    <img src="https://images.unsplash.com/photo-1474366521946-c3d4b507abf2?q=80&w=400" alt="Image Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                </a>
                            </div>

                            <div class="swiper-slide">
                                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="glightbox block relative group" data-title="Behind the Scenes">
                                    <img src="https://images.unsplash.com/photo-1455390582262-044cdead2708?q=80&w=400" alt="Video Thumbnail" class="w-full aspect-video object-cover rounded-sm shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="bg-[#2196F3] text-white rounded-full p-2 group-hover:scale-110 transition-transform shadow-lg shadow-[#2196F3]/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="swiper-button-next !text-[#5c4d42] !right-0 font-bold scale-75"></div>
                    <div class="swiper-button-prev !text-[#5c4d42] !left-0 font-bold scale-75"></div>
                </div>

            </section>

        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        function initArchiveComponents() {

            new Swiper('.featuredSwiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                navigation: {
                    nextEl: '.featured-next',
                    prevEl: '.featured-prev',
                },
                on: {
                    slideChange: function () {
                        const activeIndex = this.realIndex;
                        const categories = document.querySelectorAll('.category-carousel');

                        categories.forEach((el) => {
                            if (parseInt(el.getAttribute('data-index')) === activeIndex) {
                                el.classList.remove('hidden');
                                el.classList.add('block');
                            } else {
                                el.classList.add('hidden');
                                el.classList.remove('block');
                            }
                        });
                    }
                }
            });

            const swipers = document.querySelectorAll('.archiveSwiper');
            swipers.forEach((swiperEl) => {
                const container = swiperEl.closest('.category-carousel');
                new Swiper(swiperEl, {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    observer: true,
                    observeParents: true,
                    navigation: {
                        nextEl: container.querySelector('.swiper-button-next'),
                        prevEl: container.querySelector('.swiper-button-prev'),
                    },
                    breakpoints: {
                        640: { slidesPerView: 2, spaceBetween: 20 },
                        768: { slidesPerView: 3, spaceBetween: 30 },
                        1024: { slidesPerView: 4, spaceBetween: 30 },
                    },
                });
            });

            GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initArchiveComponents);
        } else {
            initArchiveComponents();
        }

        document.addEventListener('livewire:navigated', () => {
            setTimeout(initArchiveComponents, 50);
        });
    </script>
@endpush
