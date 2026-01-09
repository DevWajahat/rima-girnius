<div class="bg-white rounded-xl shadow-xl p-8 md:p-10 border-t-4 border-[#564744]">

    @if (session()->has('success'))
        <div class="alert alert-success bg-[#564744] text-white rounded-lg p-4 mb-6 shadow-md">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6 font-['Poppins']">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-semibold text-[#000]">First Name</span>
                </label>
                <input type="text" wire:model="first_name" placeholder="Jane" class="input input-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12" />
                @error('first_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-semibold text-[#000]">Last Name</span>
                </label>
                <input type="text" wire:model="last_name" placeholder="Doe" class="input input-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12" />
                @error('last_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text font-semibold text-[#000]">Email Address</span>
            </label>
            <input type="email" wire:model="email" placeholder="jane@example.com" class="input input-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12" />
            @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text font-semibold text-[#000]">Subject</span>
            </label>
            <input type="text" wire:model="subject" placeholder="Speaking Engagement, Book Inquiry, etc." class="input input-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12" />
            @error('subject') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text font-semibold text-[#000]">Message</span>
            </label>
            <textarea wire:model="message" class="textarea textarea-bordered h-32 w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md text-base" placeholder="Write your message here..."></textarea>
            @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="pt-2">
            <button type="submit" class="btn bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full w-full h-12 text-sm font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                <span wire:loading.remove>Send Message</span>
                <span wire:loading>Sending...</span>
            </button>
        </div>
    </form>
</div>
