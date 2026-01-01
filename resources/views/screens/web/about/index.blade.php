@extends('layouts.web.app')

@section('content')
<section class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-['Times_New_Roman'] text-[#564744] font-bold">
                About the Author
            </h1>
        </div>
    </div>
</section>

<section class="bg-[#F5F5F5] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">

            <div class="w-full md:w-5/12 flex justify-center relative shrink-0">
                <div class="card shadow-xl border-[5px] border-[#564744] rounded-sm p-1.5 bg-white transition-transform duration-500 hover:scale-[1.02]">
                    <figure class="relative h-72 w-72 sm:h-[320px] sm:w-[320px] overflow-hidden">
                        <img src="{{ asset('assets/web/images/gallery/IMG_5941.PNG') }}"
                             alt="Rima Girnius"
                             class="w-full h-full object-cover" />
                    </figure>
                </div>
            </div>

            <div class="w-full md:w-7/12 flex flex-col items-center md:items-start text-center md:text-left space-y-6">
                <div class="text-lg sm:text-xl text-[#000] italic space-y-6 leading-relaxed font-['Poppins'] font-normal">
                    <p>
                        Rima Girnius is a Lithuanian born American writer, former Radio journalist, and author of
                        <strong class="font-bold">Eureka And The Magical Trio.</strong>
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
    </div>
</section>

<section class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-medium font-['Poppins'] text-[#000]">
                Author Gallery
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
            <div class="card bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(0,0,0,0.25)]">
                <figure class="aspect-[4/5] w-full overflow-hidden">
                    <img src="{{ asset('assets/web/images/gallery/IMG_5921.jpg') }}" alt="Gallery 1" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                </figure>
            </div>

            <div class="card bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(0,0,0,0.25)]">
                <figure class="aspect-[4/5] w-full overflow-hidden">
                    <img src="{{ asset('assets/web/images/gallery/IMG_5935.PNG') }}" alt="Gallery 2" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                </figure>
            </div>

            <div class="card bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(0,0,0,0.25)]">
                <figure class="aspect-[4/5] w-full overflow-hidden">
                    <img src="{{ asset('assets/web/images/gallery/IMG_5920.jpg') }}" alt="Gallery 3" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                </figure>
            </div>

            <div class="card bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(0,0,0,0.25)]">
                <figure class="aspect-[4/5] w-full overflow-hidden">
                    <img src="{{ asset('assets/web/images/gallery/IMG_5941.PNG') }}" alt="Gallery 4" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                </figure>
            </div>

            <div class="card bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(0,0,0,0.25)]">
                <figure class="aspect-[4/5] w-full overflow-hidden">
                    <img src="{{ asset('assets/web/images/gallery/IMG_5923 (1).PNG') }}" alt="Gallery 5" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                </figure>
            </div>

            <div class="card bg-white p-2 sm:p-3 rounded-sm shadow-[0_3px_10px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_20px_rgba(0,0,0,0.25)]">
                <figure class="aspect-[4/5] w-full overflow-hidden">
                    <img src="{{ asset('assets/web/images/gallery/IMG_5922 (1).PNG') }}" alt="Gallery 6" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                </figure>
            </div>
        </div>
    </div>
</section>
@endsection
