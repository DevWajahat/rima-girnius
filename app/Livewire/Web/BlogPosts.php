<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class BlogPosts extends Component
{
    use WithPagination;

    public function render()
    {
        // 9 posts per page
        $posts = Post::latest()->paginate(9);

        return view('livewire.web.blog-posts', [
            'posts' => $posts
        ]);
    }

    // This forces Livewire to use a specific view for pagination
    public function paginationView()
    {
        return 'livewire.web.custom-pagination';
    }
}
