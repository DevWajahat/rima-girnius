	<!-- Footer (Updated: Primary Green Background) -->
    {{--	<footer class="bg-[#DFF4C7] text-dark-text border-t border-dark-text mt-20 pt-10 pb-16 px-4 sm:px-6 lg:px-8">
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
	</footer> --}}


    <!-- Footer (Updated to match table structure) -->
	<footer class="bg-[#DFF4C7] text-gray-800 border-t border-gray-300 mt-20 pt-10 pb-8 px-4 sm:px-6 lg:px-8">
		<div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-10">

            <!-- Column 1: Rima Girnius Links -->
			<div>
                <h4 class="text-base font-bold mb-3 text-gray-900">Links</h4>
				<ul class="space-y-2 text-sm">
					<li><a href="{{ route('home') }}"  wire:navigate class="hover:text-lime-600 transition duration-200">Rima Girnius</a></li>
					<li><a href="{{ route('books') }}" wire:navigate  class="hover:text-lime-600 transition duration-200">Eureka and the Magical Trio Book</a></li>
					<li><a href="{{ route('about') }}" wire:navigate  class="hover:text-lime-600 transition duration-200">About the Author</a></li>
					<li><a href="{{ route('blogs') }}" wire:navigate class="hover:text-lime-600 transition duration-200">Blogs</a></li>
				</ul>
			</div>

            <!-- Column 2: Buy Books -->
			<div>
                <h4 class="text-base font-bold mb-3 text-gray-900">Books</h4>
				<ul class="space-y-2 text-sm">
					<li><a href="{{ route('books') }}" wire:navigate class="hover:text-lime-600 transition duration-200">Buy Rima Girnius Books</a></li>
				</ul>
			</div>

			<!-- Column 3: Contact & Social -->
			<div>
				<h4 class="text-base font-bold mb-3 text-gray-900">Contact</h4>
				<ul class="space-y-4 text-sm mb-6">
					<li>
                        <span class="font-medium block mb-1">Email:</span>
                        <a href="#" class="text-gray-700 hover:text-lime-600 transition duration-200">RimaGirnius@hotmail.com</a>
                    </li>
					<li>
                        <span class="font-medium block mb-1">Follow on:</span>
                        <div class="flex space-x-3 text-xl mt-1">
                            {{-- Using Remix Icons for Social Media --}}
                            <a href="#" class="text-gray-700 hover:text-lime-600 transition duration-200" title="Instagram"><i class="ri-instagram-line"></i></a>
                            <a href="#" class="text-gray-700 hover:text-lime-600 transition duration-200" title="Twitter"><i class="ri-twitter-x-line"></i></a>
                            <a href="#" class="text-gray-700 hover:text-lime-600 transition duration-200" title="Facebook"><i class="ri-facebook-box-line"></i></a>
                        </div>
                    </li>
					<li class="mt-4">
                        <span class="font-medium block mb-2">Subscribe to Newsletter:</span>
                        <form class="flex space-x-2">
                            <input type="email" placeholder="Email" required
                                class="w-full px-3 py-1.5 border border-gray-400 rounded-lg text-sm bg-white text-gray-800 placeholder-gray-500 focus:outline-none focus:border-lime-500">
                            <button type="submit" class="flex-shrink-0 px-4 py-1.5 text-sm font-medium bg-lime-500 text-white rounded-lg hover:bg-lime-600 transition duration-300">
                                Go
                            </button>
                        </form>
                    </li>
				</ul>
			</div>

			<!-- Column 4: Copyright & Legal -->
			<div>
				<h4 class="text-base font-bold mb-3 text-gray-900">&nbsp;&nbsp;&nbsp;&nbsp;Copyright & Legal</h4>
				<ul class="space-y-2 text-sm">
					<li><p>© 2025 Rima M. Girnius</p></li>
					<li><a href="#" class="hover:text-lime-600 transition duration-200">&nbsp;&nbsp;&nbsp;&nbsp;Privacy Policy</a></li>
					<li><a href="#" class="hover:text-lime-600 transition duration-200">&nbsp;&nbsp;&nbsp;&nbsp;Terms of Service</a></li>
				</ul>
			</div>

		</div>

        <!-- Bottom Note/Signature -->
        <div class="max-w-6xl mx-auto pt-8 mt-8 border-t border-gray-300 text-xs text-center text-gray-500">
            <p>Designed with care for Rima M. Girnius.</p>
        </div>
	</footer>



