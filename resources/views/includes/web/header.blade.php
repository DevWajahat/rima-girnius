<body class="text-dark-text">

	<!-- Header & Navigation -->
	<header class="max-w-screen  overflow-hidden ">
		<nav class="flex flex-col items-center">
			<!-- Top Links -->
            <div class="w-screen flex  sm:px-6 mb-8 lg:px-8 py-4 justify-center items-center bg-[#E1E6DB] overflow-hidden">
			<div class="flex space-x-4 sm:text-[0.8rem] md:text-md lg:text-md tracking-wider uppercase text-gray-600">
            	<a href="{{ route('home') }}"  wire:navigate class="hover:text-primary-green transition duration-200">Home</a>
				<a href="{{ route('about') }}" wire:navigate class="hover:text-primary-green transition duration-200">About</a>
				<a href="{{ route('books') }}" wire:navigate class="hover:text-primary-green transition duration-200">Books</a>
				<a href="{{ route('blogs') }}" wire:navigate class="hover:text-primary-green transition duration-200">Blogs</a>
				<a href="{{ route('contact') }}" wire:navigate class="hover:text-primary-green transition duration-200">Contact</a>
			</div>

            </div>
			<!-- Main Logo/Title -->
			<h1 class="font-boldHeading text-5xl md:text-6xl tracking-widest text-center mb-10">
				RIMA GIRNIUS
			</h1>
		</nav>
	</header>


