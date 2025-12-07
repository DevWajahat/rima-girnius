@extends('layouts.web.app')

@section('content')
	<!-- Hero Section -->
	<section class="text-center max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
		<h2 class="font-montaguSlab text-3xl sm:text-4xl md:text-5xl font-medium mb-4 leading-tight">
	Embrace the Magic of Belonging.
    </h2>
		<p class="text-xl sm:text-2xl md:text-3xl italic mb-8 font-serif">
			Discover Eureka and the Magical Trio: The enchanting new novel by Lithuanian American writer Rima Girnius that celebrates heritage, self-discovery, and the powerful bond in an immigrant mother-daughter story.
		</p>
		<a href="#book-section" class="inline-block px-8 py-3 text-base font-semibold border border-dark-text rounded-full
           hover:bg-primary-green hover:text-white hover:border-primary-green transition duration-300">
			Order Your Copy Today
		</a>
	</section>


	<!-- Book Highlight Section (The Green Bar) -->
<section id="book-section" class="bg-light-green-bg py-16 px-4 sm:px-6 lg:px-8 mt-12">
		<div class="max-w-6xl mx-auto flex flex-col gap-8 md:flex-row justify-between items-center md:items-start gap-12">

			<!-- Book Cover Column -->
			<div class=" w-48 md:w-56 flex-shrink-0">
				<!-- Book Cover (Straight with Shadow) -->
				<img src="{{ asset('assets/web/images/books/eureka-book.jpg') }}"
					alt="Cover of Eureka And The Magical Trio" class="book-cover w-full object-cover shadow-2xl rounded-sm">
			</div>

			<!-- Text & CTA Column -->
			<div class="flex-grow text-center md:text-left">
				<h3 class="text-3xl font-bold mb-4">
					Eureka And The Magical Trio
				</h3>
				<!-- MODIFIED PARAGRAPH: Removed max-width and added w-full with 5px right padding -->
				<p class="mb-8 text-lg leading-relaxed w-full pr-[5px]">
					Dive into a beautifully woven tale of cultural identity YA fiction. Set in Quincy, Massachusetts, Rima Girnius’ novel introduces Eureka, a Lithuanian American teen struggling to find her place. Guided by her mother’s wisdom and the extraordinary “Magical Trio” (a kaleidoscope, a mandala, and her eyeglasses), Eureka embarks on a metaphysical journey through breathtaking landscapes inspired by Mikalojus Konstantinas Čiurlionis. This captivating blend of magical realism young adult book explores universal themes of nationality, ethnicity, and language, making it a must-read for families, educators, and anyone seeking a powerful story of self-acceptance and heritage.
				</p>

				<!-- Book Purchase Buttons -->
				<div class="flex flex-wrap justify-center md:justify-start gap-3">
					<button
						class="cta-button text-sm font-medium border border-primary-green text-primary-green px-4 py-2 rounded-full min-w-[150px]">
						BARNES & NOBLE
					</button>
					<button
						class="cta-button text-sm font-medium border border-primary-green text-primary-green px-4 py-2 rounded-full min-w-[150px]">
						AMAZON
					</button>
				</div>
                <div class="flex flex-wrap mt-2.5 justify-center md:justify-start gap-3">
					<button
						class="cta-button text-sm font-medium border border-primary-green text-primary-green px-4 py-2 rounded-full min-w-[150px]">
						BOOKSHOP
					</button>
					<button
						class="cta-button text-sm font-medium border border-primary-green text-primary-green px-4 py-2 rounded-full min-w-[150px]">
						AMAZON
					</button>
                </div>
			</div>
		</div>
	</section>






	<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
		<h3 class="text-4xl font-bold mb-12 text-center text-gray-900">
			About Me
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
					Rima Girnius is a Lithuanian-born writer, former Radio journalist, and author of <span
						class="font-extrabold text-gray-900">Eureka And The Magical Trio</span>.
				</p>
				<p class="text-lg leading-relaxed mt-4 text-gray-700">
					Blending a diverse background in Industrial Engineering and Sociology, she earned a Graduate
					Certificate in Creative Writing from Humber College and
					is currently based in Toronto, Canada.
				</p>
			</div>
		</div>
        </section>



@endsection
