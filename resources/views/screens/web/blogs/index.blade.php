@extends('layouts.web.app')
@section('content')
<section class="py-20 bg-white" id="blog">
  <div class="container mx-auto px-4 max-w-6xl">

    <div class="text-center mb-12">
      <h2 class="font-serif text-4xl font-bold text-[#333] mb-6">Latest From The Author</h2>

      <div class="flex flex-wrap justify-center gap-6 md:gap-8 text-sm font-bold tracking-widest uppercase text-gray-500 font-sans">
        <a href="#" class="text-[#5c4d42] border-b-2 border-[#5c4d42] pb-1">All</a>
        <a href="#" class="hover:text-[#5c4d42] transition-colors pb-1 border-b-2 border-transparent hover:border-[#5c4d42]">Events</a>
        <a href="#" class="hover:text-[#5c4d42] transition-colors pb-1 border-b-2 border-transparent hover:border-[#5c4d42]">Interviews</a>
        <a href="#" class="hover:text-[#5c4d42] transition-colors pb-1 border-b-2 border-transparent hover:border-[#5c4d42]">Writing Tips</a>
        <a href="#" class="hover:text-[#5c4d42] transition-colors pb-1 border-b-2 border-transparent hover:border-[#5c4d42]">Culture</a>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12 mb-16">

      <article class="group flex flex-col h-full bg-transparent">
        <a href="#" class="block overflow-hidden rounded-sm mb-5 relative aspect-[3/2]">
          <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=800&auto=format&fit=crop"
               alt="Library"
               class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
          <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </a>

        <div class="flex flex-col flex-grow">
          <div class="mb-3">
            <a href="#" class="text-[11px] font-bold uppercase tracking-widest text-[#a85f47] hover:underline">
              Culture, History
            </a>
          </div>

          <h3 class="font-serif text-2xl font-bold text-[#333] leading-tight mb-3 group-hover:text-[#5c4d42] transition-colors">
            <a href="#">The Hidden Meaning Behind Lithuanian Folk Songs</a>
          </h3>

          <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3 font-sans">
            It's nice to win awards, but the true reward lies in discovering the ancient melodies that have shaped our cultural identity for centuries.
          </p>

          <div class="mt-auto flex items-center gap-6 text-xs text-gray-400 font-sans border-t border-gray-100 pt-4">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>August 19, 2024</span>
            </div>
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
              </svg>
              <span>2 Comments</span>
            </div>
          </div>
        </div>
      </article>

      <article class="group flex flex-col h-full bg-transparent">
        <a href="#" class="block overflow-hidden rounded-sm mb-5 relative aspect-[3/2]">
          <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=800&auto=format&fit=crop"
               alt="Writing Desk"
               class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
        </a>

        <div class="flex flex-col flex-grow">
          <div class="mb-3">
            <a href="#" class="text-[11px] font-bold uppercase tracking-widest text-[#a85f47] hover:underline">
              Writing Tips
            </a>
          </div>

          <h3 class="font-serif text-2xl font-bold text-[#333] leading-tight mb-3 group-hover:text-[#5c4d42] transition-colors">
            <a href="#">5 Rituals to Restore Your Love of Writing</a>
          </h3>

          <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3 font-sans">
            In our internet world, attention is drawn in different directions. Here are my personal habits to reclaim focus and creativity.
          </p>

          <div class="mt-auto flex items-center gap-6 text-xs text-gray-400 font-sans border-t border-gray-100 pt-4">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>August 15, 2024</span>
            </div>
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
              </svg>
              <span>12 Comments</span>
            </div>
          </div>
        </div>
      </article>

      <article class="group flex flex-col h-full bg-transparent">
        <a href="#" class="block overflow-hidden rounded-sm mb-5 relative aspect-[3/2]">
          <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=800&auto=format&fit=crop"
               alt="Book Fair"
               class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
        </a>

        <div class="flex flex-col flex-grow">
          <div class="mb-3">
            <a href="#" class="text-[11px] font-bold uppercase tracking-widest text-[#a85f47] hover:underline">
              Events
            </a>
          </div>

          <h3 class="font-serif text-2xl font-bold text-[#333] leading-tight mb-3 group-hover:text-[#5c4d42] transition-colors">
            <a href="#">The London Book Fair: Meeting My Readers</a>
          </h3>

          <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3 font-sans">
            Exposure to published, well-written work has a noted effect on one's own writing. Join me this September in London.
          </p>

          <div class="mt-auto flex items-center gap-6 text-xs text-gray-400 font-sans border-t border-gray-100 pt-4">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>August 10, 2024</span>
            </div>
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
              </svg>
              <span>0 Comments</span>
            </div>
          </div>
        </div>
      </article>

    </div>

    <div class="flex justify-center gap-2 mb-20">
      <button class="btn btn-square btn-sm bg-[#5c4d42] text-white hover:bg-[#4a3b32] border-none">1</button>
      <button class="btn btn-square btn-sm bg-white text-gray-600 border border-gray-300 hover:bg-gray-100">2</button>
      <button class="btn btn-square btn-sm bg-white text-gray-600 border border-gray-300 hover:bg-gray-100">3</button>
      <button class="btn btn-sm bg-white text-gray-600 border border-gray-300 hover:bg-gray-100 px-4">Next</button>
    </div>

    <div class="text-center max-w-2xl mx-auto border-t border-gray-200 pt-16">
      <h3 class="font-serif text-3xl font-bold text-[#333] mb-4">Join Our Newsletter</h3>
      <p class="text-gray-500 mb-8 text-sm font-sans">Signup to be the first to hear about exclusive deals, special offers and upcoming collections.</p>

      <form class="flex flex-col sm:flex-row gap-3">
        <input type="email" placeholder="Enter email for weekly newsletter" class="input input-lg w-full bg-white border border-gray-300 rounded-none focus:outline-none focus:border-[#5c4d42]" />
        <button class="btn btn-lg bg-[#1C1C1C] hover:bg-[#5c4d42] text-white border-none rounded-none px-10 font-bold uppercase tracking-widest text-xs">
          Subscribe
        </button>
      </form>
    </div>

  </div>
</section>

@endsection
