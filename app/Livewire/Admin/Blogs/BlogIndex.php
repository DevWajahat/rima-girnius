<?php

namespace App\Livewire\Admin\Blogs;

use App\Models\Post; // Assuming your model is Post
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class BlogIndex extends Component
{
    use WithPagination;

    // Defines the pagination theme (bootstrap 5)
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Reset pagination when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Toggle Sort Direction
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Delete Action
    public function delete($id)
    {
        try {
            $post = Post::findOrFail($id);

            // Optional: Delete image if you have one later
            // if ($post->image) { Storage::disk('public')->delete($post->image); }

            $post->delete();

            session()->flash('message', 'Blog post deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting post: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Query with Search
        $posts = Post::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('tags', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.blogs.blog-index', [
            'posts' => $posts
        ]);
    }
}
