@extends('layouts.web.app')

@section('content')
    <section class="bg-[#F5F5F5] py-16 px-4 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <div class="mb-12 text-center">
                <h1 class="text-3xl md:text-4xl font-[Poppins] font-semibold text-center text-[#000] mb-4  tracking-tight">
                    {{ $heading }}</h1>
                <div class="w-30 h-1 bg-[#5c4d42] mx-auto rounded-full"></div>
            </div>

            @if (count($socialPosters) > 0)
                <div id="full-social-poster-gallery"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8 px-2 sm:px-0">

                    @foreach ($socialPosters as $poster)
                        @php
                            $absolutePath = storage_path('app/public/' . $poster);
                            $width = 1000;
                            $height = 1000;

                            if (file_exists($absolutePath)) {
                                $imgSize = getimagesize($absolutePath);
                                if ($imgSize) {
                                    $width = $imgSize[0];
                                    $height = $imgSize[1];
                                }
                            }
                        @endphp

                        <article
                            class="bg-white p-3 rounded-xl transition-all duration-300 hover:-translate-y-1 shadow-xl flex flex-col h-full group">
                            <div
                                class="w-full rounded-lg overflow-hidden relative bg-[#333333] flex items-center justify-center">
                                <a href="{{ asset('storage/' . $poster) }}" data-pswp-width="{{ $width }}"
                                    data-pswp-height="{{ $height }}" target="_blank"
                                    class="w-full flex items-center justify-center cursor-zoom-in">
                                    <img src="{{ asset('storage/' . $poster) }}" alt="Eureka Poster"
                                        class="w-full h-auto object-contain transform group-hover:scale-105 transition-transform duration-500">
                                </a>
                            </div>
                        </article>
                    @endforeach

                </div>
            @else
                <div class="text-center text-gray-500 py-20">
                    No posters available yet.
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe.min.css">

    <script type="module">
        import PhotoSwipeLightbox from 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe-lightbox.esm.min.js';
        import PhotoSwipe from 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.2/photoswipe.esm.min.js';

        document.addEventListener('DOMContentLoaded', () => {
            const lightbox = new PhotoSwipeLightbox({
                gallery: '#full-social-poster-gallery',
                children: 'a',
                pswpModule: PhotoSwipe,
                initialZoomLevel: 'fit',
                secondaryZoomLevel: 2,
                maxZoomLevel: 4,
            });
            lightbox.init();
        });
    </script>
@endpush
