<div class="min-h-screen flex items-center justify-center bg-[#F5F5F5] py-12 px-4 sm:px-6 lg:px-8 font-sans">

    <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8 md:p-12">

        <div class="mb-10 text-center">
            <h2 class="font-serif text-3xl text-[#333] font-bold">Welcome Back</h2>
            <p class="mt-2 text-sm text-gray-500">Please sign in to your account</p>
        </div>

        <form wire:submit.prevent="login" class="space-y-6">

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-bold text-[#333] mb-2">
                    Email Address
                </label>
                <input type="email" wire:model="email" id="email"
                       class="w-full bg-white text-gray-900 text-sm border border-gray-300 rounded-md focus:border-[#5c4d42] focus:ring-1 focus:ring-[#5c4d42] focus:outline-none px-4 py-3 transition-colors placeholder-gray-400"
                       placeholder="jane@example.com">
                @error('email') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-bold text-[#333] mb-2">
                    Password
                </label>
                <input type="password" wire:model="password" id="password"
                       class="w-full bg-white text-gray-900 text-sm border border-gray-300 rounded-md focus:border-[#5c4d42] focus:ring-1 focus:ring-[#5c4d42] focus:outline-none px-4 py-3 transition-colors placeholder-gray-400"
                       placeholder="••••••••">
                @error('password') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" wire:model="remember" id="remember"
                           class="h-4 w-4 text-[#5c4d42] focus:ring-[#5c4d42] border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-[#5c4d42] hover:text-[#333] transition-colors hover:underline">
                        Forgot password?
                    </a>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-2">
                <button type="submit"
                        class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-full text-white bg-[#5c4d42] hover:bg-[#4a3b32] uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5c4d42] transition-colors shadow-lg">
                    Sign In
                </button>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" wire:navigate class="font-bold text-[#5c4d42] hover:text-[#333] transition-colors hover:underline">
                        Create Account
                    </a>
                </p>
            </div>

        </form>
    </div>
</div>    {{-- Success is as dangerous as failure. --}}

