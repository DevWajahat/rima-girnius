<div class="min-h-screen flex items-center justify-center bg-[#F5F5F5] py-12 px-4 sm:px-6 lg:px-8 font-sans">

    <div class="max-w-2xl w-full bg-white rounded-lg shadow-xl p-8 md:p-12">

        <div class="mb-10">
            <h2 class="font-serif text-3xl text-[#333] font-bold">Create Account</h2>
        </div>

        <form wire:submit.prevent="register" class="space-y-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="firstName" class="block text-sm font-bold text-[#333] mb-3 mt-5">
                        First Name
                    </label>
                    <input type="text" wire:model="firstName" id="firstName"
                           class="w-full bg-white text-gray-900 text-sm border border-gray-300 rounded-md focus:border-[#5c4d42] focus:ring-1 focus:ring-[#5c4d42] focus:outline-none px-4 py-3 transition-colors placeholder-gray-400"
                           placeholder="Jane">
                    @error('firstName') <span class="text-xs text-red-500 font-bold mt-1 block" style="color:red;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="lastName" class="block text-sm font-bold text-[#333] mb-3 mt-5">
                        Last Name
                    </label>
                    <input type="text" wire:model="lastName" id="lastName"
                           class="w-full bg-white text-gray-900 text-sm border border-gray-300 rounded-md focus:border-[#5c4d42] focus:ring-1 focus:ring-[#5c4d42] focus:outline-none px-4 py-3 transition-colors placeholder-gray-400"
                           placeholder="Doe">
                    @error('lastName') <span class="text-xs text-red-500 font-bold mt-1 block" style="color:red" >{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-[#333] mb-2">
                    Email Address
                </label>
                <input type="email" wire:model="email" id="email"
                       class="w-full bg-white text-gray-900 text-sm border border-gray-300 rounded-md focus:border-[#5c4d42] focus:ring-1 focus:ring-[#5c4d42] focus:outline-none px-4 py-3 transition-colors placeholder-gray-400"
                       placeholder="jane@example.com">
                @error('email') <span class="text-xs text-red-500 font-bold mt-1 block" style="color:red">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-[#333] mb-2">
                    Password
                </label>
                <input type="password" wire:model="password" id="password"
                       class="w-full bg-white text-gray-900 text-sm border border-gray-300 rounded-md focus:border-[#5c4d42] focus:ring-1 focus:ring-[#5c4d42] focus:outline-none px-4 py-3 transition-colors placeholder-gray-400"
                       placeholder="••••••••">
                @error('password') <span class="text-xs text-red-600 font-bold mt-1 block " style="color:red">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-[#333] mb-2">
                    Confirm Password
                </label>
                <input type="password" wire:model="password_confirmation" id="password_confirmation"
                       class="w-full bg-white text-gray-900 text-sm border border-gray-300 rounded-md focus:border-[#5c4d42] focus:ring-1 focus:ring-[#5c4d42] focus:outline-none px-4 py-3 transition-colors placeholder-gray-400"
                       placeholder="••••••••">

                    @error('password_confirmation') <span class="text-xs text-red-600 font-bold mt-1 block" style="color:red"> {{$message}} </span>  @enderror
            </div>

            <div class="pt-6">
                <button type="submit"
                        class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-full text-white bg-[#5c4d42] hover:bg-[#4a3b32] uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5c4d42] transition-colors shadow-lg">
                    Create Account
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Already have an account?
                    <a href="" class="font-bold text-[#5c4d42] hover:text-[#333] transition-colors hover:underline">
                        Sign in
                    </a>
                </p>
            </div>

        </form>
    </div>
</div>
