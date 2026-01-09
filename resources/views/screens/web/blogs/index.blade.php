@extends('layouts.web.app')

@section('content')
<section class="py-20 bg-white" id="blog">
  <div class="container mx-auto px-4 max-w-6xl">

    <div class="text-center mb-12">
      <h2 class="font-serif text-4xl font-bold text-[#333] mb-6">Latest From The Author</h2>
    </div>

    {{-- Call the Livewire Component --}}
    <livewire:web.blog-posts />

<div class="text-center max-w-2xl mx-auto border-t border-gray-200 pt-16">
      <h3 class="font-serif text-3xl font-bold text-[#333] mb-4">Join Our Newsletter</h3>
      <p class="text-gray-500 mb-8 text-sm font-sans">Signup to be the first to hear about exclusive deals, special offers and upcoming collections.</p>

      <form class="flex flex-col sm:flex-row gap-3">
        <input type="email" placeholder="Enter email for weekly newsletter" class="input input-lg w-full bg-white border border-gray-300 rounded-none focus:outline-none focus:border-[#5c4d42]">
        <button class="btn btn-lg bg-[#1C1C1C] hover:bg-[#5c4d42] text-white border-none rounded-none px-10 font-bold uppercase tracking-widest text-xs">
          Subscribe
        </button>
      </form>
    </div>
  </div>
</section>
@endsection
