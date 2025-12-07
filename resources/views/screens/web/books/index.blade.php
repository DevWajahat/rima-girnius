@extends('layouts.web.app')
@section('content')

	<!-- Books Section -->
	<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

		<!-- Header -->
		<div class="text-center mb-16">
			<h3 class="text-4xl font-bold text-gray-900 mb-4">
				My Books
			</h3>
			<p class="text-lg text-gray-600 max-w-2xl mx-auto">
				Explore the imaginative world created by Rima Girnius, starting with her debut novel.
			</p>
		</div>

		<!-- Multiple Book Cards Grid (Simplified Structure) -->
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-24 p-4 lg:p-0">

			{{-- Book Card 1: Eureka And The Magical Trio (Available) --}}
			<div class="group bg-white rounded-xl shadow-xl transition duration-300 hover:shadow-2xl border border-gray-200 overflow-hidden">
				<div class="p-4 bg-lime-50">
					<div class="relative overflow-hidden rounded-lg h-56 flex items-center justify-center">
						{{-- Placeholder Image 1 --}}
						<img src="https://placehold.co/180x280/dcfce7/4ade80?text=Eureka+Cover"
							alt="Cover of Eureka And The Magical Trio"
							class="h-full w-auto object-cover py-2 transform transition duration-500 group-hover:scale-[1.05]">
						<span class="absolute top-2 right-2 px-3 py-1 text-sm font-bold bg-lime-500 text-white rounded-full shadow-md">Available</span>
					</div>
				</div>
				<div class="p-5 text-center">
					<h4 class="text-xl font-extrabold text-gray-900 leading-snug">Eureka And The Magical Trio</h4>
					<p class="text-2xl font-bold text-lime-600 mt-2">$14.99</p>
					<a href="#" class="mt-4 inline-block px-6 py-2 text-sm font-semibold text-lime-600 border border-lime-300 rounded-lg hover:bg-lime-50 transition duration-150">
						View Details
					</a>
				</div>
			</div>

			{{-- Book Card 2: The Secret of Whispering Woods (Upcoming) --}}
			<div class="group bg-white rounded-xl shadow-xl transition duration-300 hover:shadow-2xl border border-gray-200 overflow-hidden opacity-90">
				<div class="p-4 bg-teal-50">
					<div class="relative overflow-hidden rounded-lg h-56 flex items-center justify-center">
						{{-- Placeholder Image 2 --}}
						<img src="https://placehold.co/180x280/ccebeb/14b8a6?text=Secret+Cover"
							alt="Cover of The Secret of Whispering Woods"
							class="h-full w-auto object-cover py-2 transform transition duration-500 group-hover:scale-[1.05]">
						<span class="absolute top-2 right-2 px-3 py-1 text-sm font-bold bg-teal-500 text-white rounded-full shadow-md">Upcoming</span>
					</div>
				</div>
				<div class="p-5 text-center">
					<h4 class="text-xl font-extrabold text-gray-900 leading-snug">The Secret of Whispering Woods</h4>
					<p class="text-2xl font-bold text-gray-400 mt-2">$14.99</p>
					<span class="mt-4 inline-block px-6 py-2 text-sm font-semibold text-gray-500 border border-gray-300 rounded-lg bg-gray-100 cursor-default">
						Pre-Order Soon
					</span>
				</div>
			</div>

			{{-- Book Card 3: Adventures in Crystal Caves (Planned) --}}
			<div class="group bg-white rounded-xl shadow-xl transition duration-300 hover:shadow-2xl border border-gray-200 overflow-hidden opacity-70">
				<div class="p-4 bg-amber-50">
					<div class="relative overflow-hidden rounded-lg h-56 flex items-center justify-center">
						{{-- Placeholder Image 3 --}}
						<img src="https://placehold.co/180x280/fef3c7/f59e0b?text=Adventure+Cover"
							alt="Cover of Adventures in Crystal Caves"
							class="h-full w-auto object-cover py-2 transform transition duration-500 group-hover:scale-[1.05]">
						<span class="absolute top-2 right-2 px-3 py-1 text-sm font-bold bg-amber-500 text-white rounded-full shadow-md">Planned</span>
					</div>
				</div>
				<div class="p-5 text-center">
					<h4 class="text-xl font-extrabold text-gray-900 leading-snug">Adventures in Crystal Caves</h4>
					<p class="text-2xl font-bold text-gray-400 mt-2">TBD</p>
					<span class="mt-4 inline-block px-6 py-2 text-sm font-semibold text-gray-500 border border-gray-300 rounded-lg bg-gray-100 cursor-default">
						Status: Early Draft
					</span>
				</div>
			</div>
		</div>

		<!-- Descriptive Text Content Section (Retained) -->
		<div class="max-w-4xl mx-auto pt-16 border-t-2 border-lime-100 space-y-8 text-lg text-gray-700">
			<h4 class="text-3xl font-bold text-gray-900 mb-6">A Message from Rima on Storytelling</h4>

			<p>
				My journey as a writer is deeply rooted in my background in Industrial Engineering and Sociology. While those disciplines might seem far removed from children's fiction, they instilled in me a fascination with how things work, how people interact, and the profound importance of structure and purpose in creation. This unique blend of logic and observation fuels the magical worlds I build.
			</p>

			<p>
				<span class="font-extrabold text-lime-600">Eureka And The Magical Trio</span> is the culmination of this perspective. It's a story that celebrates curiosity, resilience, and the idea that our technical and emotional worlds are interconnected. I believe that powerful children's stories should not only entertain but also encourage young readers to look at the world with a sense of informed wonder.
			</p>

			<p>
				Thank you for visiting, and I hope you and the young readers in your life enjoy the adventure!
			</p>
		</div>

	</section>

@endsection
