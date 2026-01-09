@extends('layouts.web.app')

@section('content')

@php
    // 1. Fetch meta data for 'contact' page
    $meta = \App\Models\Cms::with('meta')->where('page', 'contact')->get();
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

<section class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-['Times_New_Roman'] text-[#564744] font-bold">
                {{ $metaArray['get-in-touch']['mainHeading']->meta_value ?? '' }}
            </h1>
            <p class="mt-4 text-lg text-gray-600 font-['Poppins'] max-w-2xl mx-auto">
        {{ $metaArray['get-in-touch']['mainSubHeading']->meta_value ?? '' }}
            </p>
        </div>
    </div>
</section>

<section class="bg-[#F5F5F5] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">

            <div class="flex flex-col gap-8">
                <div>
                    <h2 class="text-3xl font-['Times_New_Roman'] font-bold text-[#564744] mb-4">
{{ $metaArray['get-in-touch']['contentHeading']->meta_value ?? 'Get in Touch' }}                    </h2>

                    <div class="dynamic-content">
{!! $metaArray['get-in-touch']['contentDescription']->meta_value ?? 'Whether you are interested in a reading, a signed copy of <strong>Eureka and the Magical Trio</strong>, or simply want to share your thoughts, feel free to reach out.' !!}
                    </div>
                    {{--  <!-- <p class="text-gray-700 font-['Poppins'] leading-relaxed text-lg"> -->
                    <!--     Whether you are interested in a reading, a signed copy of <strong>Eureka and the Magical Trio</strong>, or simply want to share your thoughts, feel free to reach out. -->
                    <!-- </p> --> --}}
                </div>

                @if(isset($metaArray['get-in-touch']['email']->meta_value))
                <div class="space-y-6 font-['Poppins']">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#564744]/10 flex items-center justify-center shrink-0 text-[#564744]">
                            <i class="ri-mail-send-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#000] text-lg">Email</h3>
                            <a href="mailto:RimaGirnius@hotmail.com" class="text-gray-600 hover:text-[#564744] transition-colors">
                                {{ $metaArray['get-in-touch']['email']->meta_value }}
                            </a>
                        </div>
                    </div>
                    @endif


                    @if(isset($metaArray['get-in-touch']['location']->meta_value))
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#564744]/10 flex items-center justify-center shrink-0 text-[#564744]">
                            <i class="ri-map-pin-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#000] text-lg">Location</h3>
                            <p class="text-gray-600">
                                {{ $metaArray['get-in-touch']['location']->meta_value }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif


                <div class="pt-4">
                    <h3 class="font-['Poppins'] font-bold text-[#000] text-lg mb-4">Follow Me</h3>
                    <div class="flex gap-4">
                        @if(isset($metaArray['get-in-touch']['socialInstagram']->meta_value))
                        <a href="{{ $metaArray['get-in-touch']['socialInstagram']->meta_value }}" class="w-12 h-12 rounded-full border-2 border-[#564744] text-[#564744] flex items-center justify-center hover:bg-[#564744] hover:text-white transition-all duration-300">
                            <i class="ri-instagram-line text-xl"></i>
                        </a>
                        @endif

                        @if(isset($metaArray['get-in-touch']['socialX']->meta_value))
                        <a href="{{ $metaArray['get-in-touch']['socialX']->meta_value }}" class="w-12 h-12 rounded-full border-2 border-[#564744] text-[#564744] flex items-center justify-center hover:bg-[#564744] hover:text-white transition-all duration-300">
                            <i class="ri-twitter-x-line text-xl"></i>
                        </a>
                        @endif

                        @if(isset($metaArray['get-in-touch']['socialFacebook']->meta_value))
                        <a href="{{ $metaArray['get-in-touch']['socialFacebook']->meta_value }}" class="w-12 h-12 rounded-full border-2 border-[#564744] text-[#564744] flex items-center justify-center hover:bg-[#564744] hover:text-white transition-all duration-300">
                            <i class="ri-facebook-circle-fill text-xl"></i>
                        </a>
                        @endif

                    </div>
                </div>
            </div>

            <livewire:web.contact/>
        </div>
    </div>
</section>

@endsection
