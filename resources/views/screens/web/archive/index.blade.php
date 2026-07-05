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

        <div class="relative mb-20 px-0 md:px-10">
            <div class="swiper featuredSwiper pb-16">
                <div class="swiper-wrapper">
                    @forelse($playlists as $playlist)
                        <div class="swiper-slide py-4 px-2" data-id="{{ $playlist->id }}">
                            <div class="bg-white shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.1)] rounded-md p-6 flex flex-col lg:flex-row gap-8 items-center border border-gray-100">
                                <div class="w-full lg:w-1/2 relative group">
                                    <div class="block relative group rounded-sm overflow-hidden">
                                        @if($playlist->thumbnail)
                                            <img src="{{ asset('storage/' . $playlist->thumbnail) }}" alt="{{ $playlist->title }}" class="w-full h-auto aspect-video object-cover rounded-sm shadow-[20px_25px_50px_-12px_rgba(0,0,0,0.3)] transform transition-transform duration-500 group-hover:scale-[1.02]">
                                        @else
                                            <div class="w-full h-auto aspect-video bg-gray-200 flex items-center justify-center rounded-sm">
                                                <span class="text-gray-400 font-bold">NO THUMBNAIL</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-full lg:w-1/2 flex flex-col gap-4 items-center md:items-start text-center md:text-left">
                                    <span class="text-xs font-bold tracking-[0.2em] text-gray-500 uppercase">{{ $playlist->badge_label ?? 'PLAYLIST' }}</span>
                                    <h2 class="font-serif font-semibold text-3xl md:text-4xl text-[#564744] leading-[1.1]">{{ $playlist->title }}</h2>
                                    <p class="text-gray-600 text-base md:text-lg leading-relaxed max-w-xl font-light">{{ $playlist->description }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide py-10 text-center text-gray-500">No playlists found.</div>
                    @endforelse
                </div>
                <div class="swiper-pagination featured-pagination !bottom-0"></div>
            </div>

            <div class="swiper-button-next featured-next !text-[#5c4d42] !right-0 font-bold scale-75"></div>
            <div class="swiper-button-prev featured-prev !text-[#5c4d42] !left-0 font-bold scale-75"></div>
        </div>

        <section class="mb-16 min-h-[300px] border-t border-gray-300 pt-12">
            <div class="relative px-2 md:px-8">
                <div id="media-loader" class="hidden text-center py-20">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#5c4d42] mx-auto"></div>
                </div>
                <div id="media-grid-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    </div>
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

    <style>
        .swiper-pagination-bullet-active {
            background-color: #5c4d42 !important;
        }

        .featured-pagination .swiper-pagination-bullet {
        margin-bottom: ;
        width: 12px !important;
        height: 12px !important;
        opacity: 0.6;
    }

    /* Theme matched color for active dot */
    .featured-pagination .swiper-pagination-bullet-active {
        background-color: #5c4d42 !important;
        opacity: 1;
    }
    </style>

    <script>
        let glightboxInstance = null;
        let playlistCache = {};

    function initArchiveComponents() {
        new Swiper('.featuredSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: false,
            pagination: { el: '.featured-pagination', clickable: true },
            navigation: { nextEl: '.featured-next', prevEl: '.featured-prev' },
            on: {
                init: function () { if(this.slides.length > 0) handlePlaylistChange(this.slides[this.activeIndex]); },
                slideChange: function () { handlePlaylistChange(this.slides[this.activeIndex]); }
            }
        });
    }


    function handlePlaylistChange(activeSlide) {
        if(!activeSlide) return;
        const playlistId = activeSlide.getAttribute('data-id');
        if (playlistCache[playlistId]) {
            renderMedia(playlistCache[playlistId]);
        } else {
            fetchMedia(playlistId);
        }
    }


function fetchMedia(playlistId) {
        const grid = document.getElementById('media-grid-container');
        const loader = document.getElementById('media-loader');
        grid.classList.add('hidden');
        loader.classList.remove('hidden');

        fetch(`/archive/media/${playlistId}`)
            .then(res => res.json())
            .then(res => {
                playlistCache[playlistId] = res.data;
                renderMedia(res.data);
                loader.classList.add('hidden');
                grid.classList.remove('hidden');
            });
    }

function renderMedia(mediaData) {
        const grid = document.getElementById('media-grid-container');
        grid.innerHTML = '';
        if (mediaData.length > 0) {
            mediaData.forEach(media => grid.innerHTML += buildMediaGridItem(media));
        } else {
            grid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-10">No media available.</div>';
        }
        reinitializeLightbox();
    }


function buildMediaGridItem(media) {
        let url = `/storage/${media.url}`;
        let isVideo = media.type === 'video';

        return `
            <div class="relative rounded-md overflow-hidden bg-gray-100 shadow-md border border-gray-200">
                <a href="${url}" class="glightbox block relative group h-full w-full">
                    ${isVideo
                        ? `<video src="${url}#t=0.5" class="w-full h-48 md:h-64 object-cover" muted playsinline></video>
                           <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="bg-blue-500/80 text-white rounded-full p-3 shadow-lg"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></div>
                           </div>`
                        : `<img src="${url}" class="w-full h-48 md:h-64 object-cover">`
                    }
                </a>
            </div>
        `;
    }





    function reinitializeLightbox() {
        if (glightboxInstance) glightboxInstance.destroy();
        glightboxInstance = GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });
    }

    document.addEventListener('DOMContentLoaded', initArchiveComponents);</script>
@endpush
