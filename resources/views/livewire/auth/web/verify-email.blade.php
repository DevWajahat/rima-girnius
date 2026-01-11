<div class="min-h-screen flex items-center justify-center bg-[#F5F5F5] py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8 md:p-12 text-center">

        <div class="mb-6">
            <h2 class="font-serif text-3xl text-[#333] font-bold">Verify Your Email</h2>
            <p class="mt-4 text-sm text-gray-500">
                Thanks for signing up! Before you can purchase books, please verify your email address by clicking on the link we just emailed to you.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 font-medium text-sm text-[#5c4d42] bg-[#5c4d42]/10 p-3 rounded-md">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="space-y-4">
            {{-- Resend Button --}}
            <button wire:click="resend" wire:loading.attr="disabled"
                class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-full text-white bg-[#5c4d42] hover:bg-[#4a3b32] uppercase tracking-widest focus:outline-none shadow-lg transition-colors">
                <span wire:loading.remove>Resend Verification Email</span>
                <span wire:loading>Sending...</span>
            </button>

            {{-- Logout (In case they used the wrong email) --}}
            <a href="{{ route('logout') }}" wire:navigate
                class="text-sm text-gray-500 underline hover:text-[#333]">
                Log Out
            </a>

            {{-- Hidden Logout Form (Standard Laravel) --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>

    </div>
</div>
