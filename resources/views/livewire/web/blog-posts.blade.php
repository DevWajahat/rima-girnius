<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12 mb-16">
        @forelse($posts as $post)
            <article class="group flex flex-col h-full bg-transparent">
                <a href="{{ route('blogs.show', $post->id) }}" class="block overflow-hidden rounded-sm mb-5 relative aspect-[3/2]">
                    <img src="{{ asset('storage/'. $post->image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>

                <div class="flex flex-col flex-grow">
                    <h3 class="font-serif text-2xl font-bold text-[#333] leading-tight mb-3 group-hover:text-[#5c4d42] transition-colors">
                        <a href="{{ route('blogs.show', $post->id) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3 font-sans">
                        {{ $post->description }}
                    </p>

                    <div class="mt-auto flex items-center gap-6 text-xs text-gray-400 font-sans border-t border-gray-100 pt-4">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $post->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                No posts found.
            </div>
        @endforelse
    </div>

    {{-- Livewire Pagination Links --}}
    <div class="mb-20">
        {{ $posts->links() }}
    </div>
</div>
