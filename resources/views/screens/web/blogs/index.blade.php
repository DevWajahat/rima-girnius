@extends('layouts.web.app')
@section('content')

	<!-- Hero/Header Section -->
	<div class="bg-gray-50 pt-16 pb-10 px-4 sm:px-6 lg:px-8">
		<div class="max-w-6xl mx-auto">
			<h1 class="text-6xl font-bold text-gray-900 text-center tracking-tighter mb-2">
			    Blogs
			</h1>
		</div>
	</div>

	<!-- Main Content Area (Now only Featured Cards) -->
	<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

		<!-- Featured Article Card 1 -->
		<div class="mb-12">
			<div class="bg-white p-6 md:p-10 rounded-2xl shadow-2xl border border-gray-100">
				<div class="flex flex-col lg:flex-row gap-8">

					<!-- Image Area -->
					<div class="lg:w-1/2 flex-shrink-0">
						<div class="relative rounded-xl overflow-hidden shadow-lg h-64 md:h-80 lg:h-full">
							{{-- Placeholder for a relevant image --}}
							<img src="{{ asset('assets/web/images/blogs/blog1.jpg') }}"
								alt="Writing inspiration setup" style="width:502px; height:420px;" class=" object-cover rounded-xl shadow-lg">
						</div>
					</div>

					<!-- Text Content Area -->
					<div class="lg:w-1/2 flex flex-col justify-center">
						<div class="flex items-center space-x-3 mb-3">
							<span class="text-sm font-medium text-lime-700 bg-lime-100 px-3 py-1 rounded-full">New!</span>
							<span class="text-sm text-gray-500">5 min read</span>
						</div>
						<h2 class="text-4xl font-semibold text-gray-900 mb-4 leading-snug">
							Bridging Worlds: How Magical Realism Unpacks the Immigrant Experience
						</h2>
						<p class="text-lg text-gray-700 mb-6">
                        The journey of an immigrant family is often one of resilience, adaptation, and the delicate balancing act between two cultures. In the realm of literature, few genres capture this complex emotional and spiritual landscape as powerfully as magical realism.
						</p>
						<a href="#" class="text-lime-600 font-semibold flex items-center hover:text-lime-700 transition duration-150">
							Read More
							<i class="ri-arrow-right-line ml-1"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Featured Article Card 2 (Similar Styling) -->
		<div class="mb-16">
			<div class="bg-white p-6 md:p-10 rounded-2xl shadow-2xl border border-gray-100">
				<div class="flex flex-col lg:flex-row gap-8">

					<!-- Image Area -->
					<div class="lg:w-1/2 flex-shrink-0 order-first lg:order-last">
						<div class="relative rounded-xl overflow-hidden shadow-lg h-64 md:h-80 lg:h-full">
							{{-- Placeholder for a relevant image --}}
							<img src="{{ asset('assets/web/images/blogs/blog2.jpg') }}" style="width:502px; height:420px;"
								alt="Image representing Lithuanian culture" class="w-full h-full object-cover">
						</div>
					</div>

					<!-- Text Content Area -->
					<div class="lg:w-1/2 flex flex-col justify-center">
						<div class="flex items-center space-x-3 mb-3">
							<span class="text-sm font-medium text-lime-700 bg-lime-100 px-3 py-1 rounded-full">Culture</span>
							<span class="text-sm text-gray-500">8 min read</span>
						</div>
						<h2 class="text-4xl font-semibold text-gray-900 mb-4 leading-snug">
					Exploring Heritage: The Importance of Cultural Roots in YA Literature
                    </h2>
						<p class="text-lg text-gray-700 mb-6">
					In an increasingly globalized world, the question of "Where do I belong?" is more critical than ever, particularly for young adults. The exploration of cultural heritage is a vital theme in literature, providing readers with both a mirror and a window into the complexities of identity.
                    </p>
						<a href="#" class="text-lime-600 font-semibold flex items-center hover:text-lime-700 transition duration-150">
							Read More
							<i class="ri-arrow-right-line ml-1"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

	</section>

@endsection
