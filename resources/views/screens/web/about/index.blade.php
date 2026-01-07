@extends('layouts.web.app')

@section('content')

@php
    // 1. Fetch meta data for 'about' page
    $meta = \App\Models\Cms::with('meta')->where('page', 'about')->get();
    $metaArray = [];

    // 2. Organize into array [section_type][meta_key]
    foreach ($meta as $query) {
        foreach ($query->meta as $item) {
            if ($query->type == $item->cms->type) {
                if (!isset($metaArray[$query->type])) {
                    $metaArray[$query->type] = [];
                }
                $metaArray[$query->type][$item->meta_key] = $item;
            }
        }
    }
@endphp

{{-- SECTION 1: Page Title --}}
<section class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-['Times_New_Roman'] text-[#564744] font-bold">
                {{ $metaArray['about-section']['aboutHeading']->meta_value ?? 'About the Author' }}
            </h1>
        </div>
    </div>
</section>

{{-- SECTION 2: Image & Description --}}
<section class="bg-[#F5F5F5] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">

            {{-- Left: Author Image --}}
            <div class="w-full md:w-5/12 flex justify-center relative shrink-0">
                <div class="card shadow-xl border-[5px] border-[#564744] rounded-sm p-1.5 bg-white transition-transform duration-500 hover:scale-[1.02]">
                    <figure class="relative h-72 w-72 sm:h-[320px] sm:w-[320px] overflow-hidden">
                        <img
                            src="{{ isset($metaArray['about-section']['aboutImage']->meta_value)
                                    ? asset('storage/' . $metaArray['about-section']['aboutImage']->meta_value)
                                    : asset('assets/web/images/gallery/IMG_5941.PNG') }}"
                            alt="Author Image"
                            class="w-full h-full object-cover"
                        />
                    </figure>
                </div>
            </div>

            {{-- Right: Description --}}
            <div class="w-full md:w-7/12 flex flex-col items-center md:items-start text-center md:text-left space-y-6">
                <div class="text-lg sm:text-xl text-[#000] italic space-y-6 leading-relaxed font-['Poppins'] font-normal">
                    {!! $metaArray['about-section']['aboutDescription']->meta_value ?? '' !!}
                </div>
            </div>

        </div>
    </div>
</section>

{{-- SECTION 3: Gallery --}}
@php
    // Corrected Key: 'author-gallery'
    $galleryImages = isset($metaArray['author-gallery']['galleryImages']->meta_value)
        ? json_decode($metaArray['author-gallery']['galleryImages']->meta_value, true)
        : [];
@endphp

@if(!empty($galleryImages))
<section class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        {{-- Gallery Heading --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl font-medium font-['Poppins'] text-[#000]">
                {{ $metaArray['author-gallery']['authorHeading']->meta_value ?? 'Author Gallery' }}
            </h2>
        </div>

        {{-- Gallery Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($galleryImages as $img)
                <div class="card bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(0,0,0,0.25)]">
                    <figure class="aspect-[4/5] w-full overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $img) }}"
                            alt="Gallery Image {{ $loop->iteration }}"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                        />
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
