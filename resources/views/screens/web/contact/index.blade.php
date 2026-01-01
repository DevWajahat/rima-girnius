@extends('layouts.web.app')

@section('content')

<section class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-['Times_New_Roman'] text-[#564744] font-bold">
                Contact
            </h1>
            <p class="mt-4 text-lg text-gray-600 font-['Poppins'] max-w-2xl mx-auto">
                Have a question about the book, or just want to say hello? I'd love to hear from you.
            </p>
        </div>
    </div>
</section>

<section class="bg-[#F5F5F5] py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">

            <div class="flex flex-col gap-8">
                <div>
                    <h2 class="text-3xl font-['Times_New_Roman'] font-bold text-[#564744] mb-4">
                        Get in Touch
                    </h2>
                    <p class="text-gray-700 font-['Poppins'] leading-relaxed text-lg">
                        Whether you are interested in a reading, a signed copy of <strong>Eureka and the Magical Trio</strong>, or simply want to share your thoughts, feel free to reach out.
                    </p>
                </div>

                <div class="space-y-6 font-['Poppins']">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#564744]/10 flex items-center justify-center shrink-0 text-[#564744]">
                            <i class="ri-mail-send-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#000] text-lg">Email</h3>
                            <a href="mailto:RimaGirnius@hotmail.com" class="text-gray-600 hover:text-[#564744] transition-colors">
                                RimaGirnius@hotmail.com
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#564744]/10 flex items-center justify-center shrink-0 text-[#564744]">
                            <i class="ri-map-pin-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#000] text-lg">Location</h3>
                            <p class="text-gray-600">
                                Duxbury, MA, USA
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <h3 class="font-['Poppins'] font-bold text-[#000] text-lg mb-4">Follow Me</h3>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 rounded-full border-2 border-[#564744] text-[#564744] flex items-center justify-center hover:bg-[#564744] hover:text-white transition-all duration-300">
                            <i class="ri-instagram-line text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full border-2 border-[#564744] text-[#564744] flex items-center justify-center hover:bg-[#564744] hover:text-white transition-all duration-300">
                            <i class="ri-twitter-x-line text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full border-2 border-[#564744] text-[#564744] flex items-center justify-center hover:bg-[#564744] hover:text-white transition-all duration-300">
                            <i class="ri-facebook-circle-fill text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-xl p-8 md:p-10 border-t-4 border-[#564744]">
                <form action="#" method="POST" class="space-y-6 font-['Poppins']">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-[#000]">First Name</span>
                            </label>
                            <input type="text" placeholder="Jane" class="input input-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-[#000]">Last Name</span>
                            </label>
                            <input type="text" placeholder="Doe" class="input input-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12" />
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold text-[#000]">Email Address</span>
                        </label>
                        <input type="email" placeholder="jane@example.com" class="input input-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold text-[#000]">Subject</span>
                        </label>
                        <select class="select select-bordered w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md h-12 font-normal">
                            <option disabled selected>Select a topic</option>
                            <option>Book Inquiry</option>
                            <option>Speaking Engagement</option>
                            <option>General Message</option>
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold text-[#000]">Message</span>
                        </label>
                        <textarea class="textarea textarea-bordered h-32 w-full bg-white focus:outline-none focus:border-[#564744] focus:ring-1 focus:ring-[#564744] rounded-md text-base" placeholder="Write your message here..."></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full w-full h-12 text-sm font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
