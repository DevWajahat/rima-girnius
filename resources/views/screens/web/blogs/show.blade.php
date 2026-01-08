@extends('layouts.web.app')

@section('content')

    {{-- 1. HERO IMAGE --}}
    <div class="w-full h-[400px] md:h-[550px] relative z-0">
        <img src="{{ asset('storage/' . $post->image) }}"
             alt="{{ $post->title }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/10"></div>
    </div>

    {{-- 2. CONTENT CONTAINER --}}
    <article class="relative z-10 container mx-auto px-4 max-w-4xl -mt-24 mb-20">

        <div class="bg-white shadow-xl rounded-sm p-8 md:p-16">

            {{-- Category --}}
            <div class="text-center mb-6">
                <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#a85f47]">
                    Blog Post
                </span>
            </div>

            {{-- 3. TITLE --}}
            <h1 class="text-center font-serif text-3xl md:text-5xl font-bold text-[#333] leading-tight mb-6">
                {{ $post->title }}
            </h1>

            {{-- Meta Data --}}
            <div class="flex justify-center items-center gap-6 text-xs font-sans text-gray-400 font-bold uppercase tracking-widest mb-12 border-b border-gray-100 pb-8">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $post->created_at->format('F d, Y') }}</span>
                </div>
            </div>

            {{-- 4. EDITOR.JS CONTENT PARSER --}}
            <div class="font-sans text-gray-600 leading-8 text-[17px] space-y-6 editor-js-content">

                @php
                    // Decode JSON if it's a string, otherwise use as object
                    $contentData = is_string($post->content) ? json_decode($post->content) : $post->content;
                    $blocks = $contentData->blocks ?? [];
                @endphp

                @foreach($blocks as $block)

                    {{-- HEADER --}}
                    @if($block->type == 'header')
                        @php $level = $block->data->level ?? 2; @endphp
                        <h{{ $level }} class="font-serif font-bold text-[#333] mt-8 mb-4
                            {{ $level == 1 ? 'text-4xl' : ($level == 2 ? 'text-3xl' : 'text-2xl') }}">
                            {!! $block->data->text !!}
                        </h{{ $level }}>

                    {{-- PARAGRAPH --}}
                    @elseif($block->type == 'paragraph')
                        <p class="mb-4">
                            {!! $block->data->text !!}
                        </p>

                    {{-- LIST --}}
                    @elseif($block->type == 'list')
                        <ul class="list-disc pl-6 space-y-2 mb-6">
                            @foreach($block->data->items as $item)
                                {{-- FIX: Ensure $item is treated as string. Some editor versions store items as objects --}}
                                <li>{!! is_string($item) ? $item : ($item->content ?? '') !!}</li>
                            @endforeach
                        </ul>

                    {{-- QUOTE --}}
                    @elseif($block->type == 'quote')
                        <blockquote class="border-l-4 border-[#5c4d42] pl-6 py-2 my-8 italic text-xl font-serif text-[#5c4d42] bg-[#F9F9F9]">
                            "{!! $block->data->text !!}"
                            @if(!empty($block->data->caption))
                                <footer class="text-sm not-italic text-gray-500 mt-2">- {!! $block->data->caption !!}</footer>
                            @endif
                        </blockquote>

                    {{-- IMAGE --}}
                    @elseif($block->type == 'image')
                        <figure class="my-8">
                            <img src="{{ $block->data->file->url }}" alt="{{ $block->data->caption ?? '' }}" class="w-full rounded-sm">
                            @if(!empty($block->data->caption))
                                <figcaption class="text-center text-xs text-gray-400 mt-2">{{ $block->data->caption }}</figcaption>
                            @endif
                        </figure>

                    {{-- DELIMITER --}}
                    @elseif($block->type == 'delimiter')
                        <div class="flex justify-center py-8 text-2xl tracking-widest text-[#5c4d42]">* * *</div>

                    @endif

                @endforeach

            </div>

            {{-- Footer --}}
            <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-gray-100 text-xs font-bold uppercase tracking-wider text-gray-500 rounded-sm">Article</span>
                </div>
            </div>

        </div>
    </article>

@endsection
