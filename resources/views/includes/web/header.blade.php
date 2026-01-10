<body class="bg-white text-gray-800 font-[Poppins] antialiased">

<div class="w-full pt-8 px-6 md:px-12 pb-6 relative z-50">

        <nav class="w-full max-w-[1440px] mx-auto bg-[#F5F5F5] min-h-[90px] flex items-center justify-between px-6 md:px-10 shadow-sm relative z-50">

            <div class="flex-1">
                <a href="{{ route('home') }}" wire:navigate class="font-[Poppins]  font-bold text-2xl md:text-3xl font-black text-black uppercase tracking-wide decoration-transparent hover:opacity-70 transition-opacity">
                    Rima Girnius
                </a>
            </div>

            <div class="hidden lg:flex flex-none">
                <ul class="flex gap-8 items-center">
                    <li><a href="{{ route('home') }}" wire:navigate class="text-[15px] font-medium text-#000 uppercase tracking-[0.2em] hover:text-black transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" wire:navigate class="text-[15px] font-medium text-#000 uppercase tracking-[0.2em] hover:text-black transition-colors">About</a></li>
                    <li><a href="{{ route('books') }}" wire:navigate class="text-[15px] font-medium text-#000 uppercase tracking-[0.2em] hover:text-black transition-colors">Books</a></li>
                    <li><a href="{{ route('blogs') }}" wire:navigate class="text-[15px] font-medium text-#000 uppercase tracking-[0.2em] hover:text-black transition-colors">Blogs</a></li>
                    <li><a href="{{ route('contact') }}" wire:navigate class="text-[15px] font-medium text-#000 uppercase tracking-[0.2em] hover:text-black transition-colors">Contact</a></li>


                    @auth
                    <li><a href="{{ route('logout') }}" wire:navigate class="py-2 px-3 text-white bg-[#5c4d42] text-sm font-extrabold border-2 border-[#5c4d42] hover:bg-white hover:text-[#5c4d42] rounded-md transition-colors">Logout</a></li>

                    @else
                    <li>
                        <a href="{{ route('register') }}" wire:navigate
                           class="py-2 px-3 text-[#5c4d42] text-sm font-extrabold border-2 border-[#5c4d42] hover:bg-[#5c4d42] rounded-md hover:text-white transition-colors">
                            Register</a>
                    </li>

                    <li>
                        <a href="{{route('login') }}" wire:navigate
                           class="py-2 px-3 text-white bg-[#5c4d42] text-sm font-extrabold border-2 border-[#5c4d42] hover:bg-white hover:text-[#5c4d42] rounded-md transition-colors">
                            Login</a>
                    </li>

                    @endauth


                </ul>
            </div>

            <div class="flex-none lg:hidden">
                <label for="mobile-drawer-toggle" class="cursor-pointer p-2 hover:bg-gray-200 rounded-md transition-colors text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>
            </div>

        </nav>

        <input type="checkbox" id="mobile-drawer-toggle" class="peer hidden">

        <label for="mobile-drawer-toggle" class="fixed inset-0 bg-black/50 z-[60] hidden peer-checked:block transition-opacity backdrop-blur-sm cursor-pointer"></label>

        <div class="fixed top-0 right-0 h-full w-[300px] bg-white z-[70] translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">

            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <span class="text-lg font-black uppercase text-black font-sans">Menu</span>
                <label for="mobile-drawer-toggle" class="cursor-pointer p-2 hover:bg-gray-100 rounded-full transition-colors text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </label>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <ul class="flex flex-col gap-2">
                    <li><a href="{{ route('home') }}" wire:navigate class="block py-4 text-sm font-bold uppercase tracking-widest text-gray-700 hover:text-black hover:bg-gray-50 border-b border-gray-100 transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" wire:navigate class="block py-4 text-sm font-bold uppercase tracking-widest text-gray-700 hover:text-black hover:bg-gray-50 border-b border-gray-100 transition-colors">About</a></li>
                    <li><a href="{{ route('books') }}" wire:navigate class="block py-4 text-sm font-bold uppercase tracking-widest text-gray-700 hover:text-black hover:bg-gray-50 border-b border-gray-100 transition-colors">Books</a></li>
                    <li><a href="{{ route('blogs') }}" wire:navigate class="block py-4 text-sm font-bold uppercase tracking-widest text-gray-700 hover:text-black hover:bg-gray-50 border-b border-gray-100 transition-colors">Blogs</a></li>
                    <li><a href="{{ route('contact') }}" wire:navigate class="block py-4 text-sm font-bold uppercase tracking-widest text-gray-700 hover:text-black hover:bg-gray-50 transition-colors">Contact</a></li>
                </ul>
            </div>

            <div class="p-6 bg-gray-50">
                <p class="text-xs text-center text-gray-400">&copy; 2024 Rima Girnius</p>
            </div>
        </div>

</div>
