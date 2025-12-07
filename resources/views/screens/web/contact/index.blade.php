@extends('layouts.web.app')
@section('content')

	<!-- Contact Section -->
	<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

		<!-- Header -->
		<div class="text-center mb-12">
			<h3 class="text-4xl font-bold text-gray-900 mb-4">
				Get in Touch
			</h3>
			<p class="text-lg text-gray-600 max-w-2xl mx-auto">
				Ready to connect? Send a message below to reach out to Rima for book signings, press inquiries, or just to say hello.
			</p>
		</div>

		<!-- Contact Form Card -->
		<div class="bg-white p-8 sm:p-10 rounded-xl shadow-2xl border border-gray-100">
			<form action="#" method="POST" class="space-y-6">

				<!-- Name and Email (Two Columns) -->
				<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

					<div>
						<label for="name" class="block text-base font-semibold text-gray-700 mb-2">Your Name</label>
						<input type="text" name="name" id="name" placeholder="Your Name" required
							class="w-full px-4 py-3 border-2 border-lime-300 focus:border-lime-500 rounded-lg shadow-sm focus:ring-lime-500 focus:outline-none transition duration-150 text-gray-700">
					</div>

					<div>
						<label for="email" class="block text-base font-semibold text-gray-700 mb-2">Your Email</label>
						<input type="email" name="email" id="email" placeholder="Your Email" required
							class="w-full px-4 py-3 border-2 border-lime-300 focus:border-lime-500 rounded-lg shadow-sm focus:ring-lime-500 focus:outline-none transition duration-150 text-gray-700">
					</div>
				</div>

				<!-- Subject (Full Width) -->
				<div>
					<label for="subject" class="block text-base font-semibold text-gray-700 mb-2">Subject</label>
					<input type="text" name="subject" id="subject" placeholder="What is this about?" required
						class="w-full px-4 py-3 border-2 border-lime-300 focus:border-lime-500 rounded-lg shadow-sm focus:ring-lime-500 focus:outline-none transition duration-150 text-gray-700">
				</div>

				<!-- Message (Textarea) -->
				<div>
					<label for="message" class="block text-base font-semibold text-gray-700 mb-2">Your Message</label>
					<textarea name="message" id="message" rows="5" placeholder="Write your message here..." required
						class="w-full px-4 py-3 border-2 border-lime-300 focus:border-lime-500 rounded-lg shadow-sm focus:ring-lime-500 focus:outline-none transition duration-150 text-gray-700 resize-none"></textarea>
				</div>

				<!-- Newsletter Checkbox (with FlyonUI style and Remix Icon checkmark) -->
				<div class="flex items-start pt-2">
					<div class="flex items-center h-5">
						{{-- Using a custom checkmark style for the lime look --}}
						<input id="newsletter" name="newsletter" type="checkbox"
							class="w-5 h-5 text-lime-600 bg-lime-100 border-lime-300 rounded focus:ring-lime-500 checked:bg-lime-500 checked:text-white" />
					</div>
					<div class="ml-3 text-sm">
						<label for="newsletter" class="font-medium text-gray-700 cursor-pointer">
							Sign up for newsletter updates
						</label>
					</div>
				</div>


				<!-- Submit Button -->
				<div class="pt-4">
					<button type="submit"
						class="w-full sm:w-auto px-8 py-3 bg-lime-500 text-white font-bold text-lg rounded-lg shadow-md hover:bg-lime-600 focus:outline-none focus:ring-4 focus:ring-lime-300 transition duration-150 ease-in-out transform hover:scale-[1.01] uppercase tracking-wider">
						Submit
					</button>
				</div>
			</form>
		</div>
	</section>

@endsection
