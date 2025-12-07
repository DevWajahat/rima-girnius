	<!-- Footer (Updated: Primary Green Background) -->
	<footer class="bg-[#DFF4C7] text-dark-text border-t border-dark-text mt-20 pt-10 pb-16 px-4 sm:px-6 lg:px-8">
		<div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">

			<!-- Column 1: Links -->
			<div>
				<ul class="space-y-2 text-sm">
					<li><a href="{{ route('home') }}" class="transition duration-200">Home</a></li>
					<li><a href="{{ route('about') }}" class="transition duration-200">About</a></li>
					<li><a href="#" class="transition duration-200">Books</a></li>
					<li><a href="#" class="transition duration-200">Blogs</a></li>
                    <li><a href="{{ route('contact') }}" class="transition duration-200">Contact</a></li>

				</ul>
			</div>

			<!-- Column 2: Newsletter -->
			<div>
				<p class="text-base mb-4">Subscribe to our newsletter</p>
				<form class="flex flex-col space-y-3">
					<input type="email" placeholder="Enter your email" required
						class="w-full px-4 py-2 border-b border-dark-text bg-transparent text-dark-text placeholder-gray-600 focus:outline-none focus:border-white">
					<!-- Button style adjusted for contrast on green background -->
					<button type="submit" class="self-start px-6 py-2 text-sm font-medium border border-dark-text text-dark-text rounded-full
                            hover:bg-dark-text hover:text-white hover:border-dark-text transition duration-300">
						Subscribe
					</button>
				</form>
			</div>

			<!-- Column 3: Connect -->
			<div>
				<p class="text-base mb-4">Connect</p>
				<div class="flex space-x-4 text-xl">
					<!-- Icon color is dark-text, hover is white -->
					<a href="#" class="text-dark-text hover:text-white transition duration-200" title="Instagram">
						&#x1F4F7;
					</a>
					<a href="#" class="text-dark-text hover:text-white transition duration-200" title="Twitter">
						&#x1F426;
					</a>
					<a href="#" class="text-dark-text hover:text-white transition duration-200" title="Facebook">
						&#x1F4D6;
					</a>
					<a href="#" class="text-dark-text hover:text-white transition duration-200" title="YouTube">
						&#x1F4FA;
					</a>
				</div>
			</div>
		</div>
	</footer>




