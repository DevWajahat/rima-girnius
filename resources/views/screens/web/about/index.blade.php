@extends('layouts.web.app')
@section('content')


	<!-- About Section -->
	<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
		<h3 class="text-5xl font-bold mb-12 text-center text-gray-900">
			About The Author
		</h3>

		{{-- Author Bio and Image Section --}}
		<div class="flex flex-col md:flex-row items-center md:items-start gap-10 mb-20">

			<!-- Author Image (Circular) -->
			<div class="w-48 h-48 md:w-64 md:h-64 rounded-full overflow-hidden mx-auto md:mx-0 shadow-2xl border-4 border-white ring-4 ring-lime-200 flex-shrink-0">
				<img src="{{ asset('assets/web/images/profile/profile.jpg') }}"
					alt="Portrait of the author, Rima Girnius" class="w-full h-full object-cover">
			</div>

			<!-- Author Bio -->
			<div class="md:pt-10 text-center md:text-left">

            <p class="text-xl leading-relaxed text-gray-700">
Rima M. Girnius is a distinguished Lithuanian American writer who brings a unique blend of storytelling and academic insight to her work. With a strong professional background in journalism and sociology, Rima crafts narratives rich in cultural authenticity and emotional depth. Her work, especially Eureka and the Magical Trio, explores the vital intersection of heritage, transformation, and personal identity, offering profound perspectives on the immigrant experience. A dedicated advocate for cultural understanding, Rima’s books on immigration and identity resonate with readers seeking powerful, meaningful stories. Connect with Rima to follow her journey and learn more about the inspiration behind her writing.
            </p>

				<!-- <p class="text-xl leading-relaxed text-gray-700"> -->
				<!-- 	Rima Girnius is a Lithuanian-born writer, former Radio journalist, and author of <span -->
				<!-- 		class="font-extrabold text-gray-900">Eureka And The Magical Trio</span>. -->
				<!-- </p> -->
				<!-- <p class="text-lg leading-relaxed mt-4 text-gray-700"> -->
				<!-- 	Blending a diverse background in Industrial Engineering and Sociology, she earned a Graduate -->
				<!-- 	Certificate in Creative Writing from Humber College and -->
				<!-- 	is currently based in Toronto, Canada. -->
				<!-- </p> -->
			</div>
		</div>

		{{-- Detail Elements Grid --}}
		<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">

			{{-- Detail Card 1: Born in Lithuania --}}
			<div class="flex items-start space-x-4 p-6 bg-white rounded-xl shadow-lg transition duration-300 hover:shadow-xl hover:scale-[1.02] transform border-l-4 border-lime-500">
				<div class="flex-shrink-0 w-14 h-14 bg-lime-100 rounded-full flex items-center justify-center text-lime-600">
					<i class="ri-graduation-cap-line text-2xl"></i>
				</div>
				<div>
					<h4 class="text-xl font-bold mb-1 text-gray-800">Born in Lithuania</h4>
					<p class="text-gray-600">Born in lithuania, she started her life and education during the Soviet era.</p>
				</div>
			</div>

			{{-- Detail Card 2: Engineering & Sociology --}}
			<div class="flex items-start space-x-4 p-6 bg-white rounded-xl shadow-lg transition duration-300 hover:shadow-xl hover:scale-[1.02] transform border-l-4 border-lime-500">
				<div class="flex-shrink-0 w-14 h-14 bg-lime-100 rounded-full flex items-center justify-center text-lime-600">
					<i class="ri-book-open-line text-2xl"></i>
				</div>
				<div>
					<h4 class="text-xl font-bold mb-1 text-gray-800">Engineering & Sociology</h4>
					<p class="text-gray-600">Educated in Vilnius with a background in Industrial & Civil Engineering, followed by a Master’s degree in Applied Sociology.</p>
				</div>
			</div>

			{{-- Detail Card 3: Voice of the Radio --}}
			<div class="flex items-start space-x-4 p-6 bg-white rounded-xl shadow-lg transition duration-300 hover:shadow-xl hover:scale-[1.02] transform border-l-4 border-lime-500">
				<div class="flex-shrink-0 w-14 h-14 bg-lime-100 rounded-full flex items-center justify-center text-lime-600">
					<i class="ri-mic-line text-2xl"></i>
				</div>
				<div>
					<h4 class="text-xl font-bold mb-1 text-gray-800">Voice of the Radio</h4>
					<p class="text-gray-600">Worked as a Radio Journalist for the Lithuanian National Radio.</p>
				</div>
			</div>

			{{-- Detail Card 4: Creative Writing --}}
			<div class="flex items-start space-x-4 p-6 bg-white rounded-xl shadow-lg transition duration-300 hover:shadow-xl hover:scale-[1.02] transform border-l-4 border-lime-500">
				<div class="flex-shrink-0 w-14 h-14 bg-lime-100 rounded-full flex items-center justify-center text-lime-600">
					<i class="ri-leaf-line text-2xl"></i>
				</div>
				<div>
					<h4 class="text-xl font-bold mb-1 text-gray-800">Creative Writing</h4>
					<p class="text-gray-600">Earned a Graduate Certificate in Creative Writing from Humber College in Toronto.</p>
				</div>
			</div>

		</div>

	</section>


@endsection
