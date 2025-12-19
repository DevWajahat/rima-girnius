<?php

namespace App\Livewire\Admin\Blogs;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class BlogCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $content; // Stores the JSON from EditorJS
    public $meta_title;
    public $meta_description;
    public $meta_keyword;
    public $tags;

    // Additional helpful fields
    public $featured_image;

protected $rules = [
        'title' => 'required|min:3|max:255',
        // 'content' rule is removed here; we will validate it manually inside save()
        'meta_title' => 'required|max:100',       // Changed from nullable
        'meta_description' => 'required|max:160', // Changed from nullable
        'meta_keyword' => 'required|max:255',     // Changed from nullable
        'tags' => 'required|string',              // Changed from nullable
        'featured_image' => 'required|image|max:2048', // Changed from nullable
    ];


    public function updatedTitle($value)
    {
        // Auto-generate meta title if empty
        if (!$this->meta_title) {
            $this->meta_title = Str::limit($value, 60);
        }
    }

// 1. Add $editorContent as an optional argument
    public function save($editorContent = null)
    {
        // 2. If content is passed from JS, assign it immediately
        if ($editorContent) {
            $this->content = $editorContent;
        }

        // 3. Now validate.
        $this->validate();

        // Handle Image Upload
        $imagePath = null;
        if ($this->featured_image) {
            $imagePath = $this->featured_image->store('uploads/blogs', 'public');
        }

        // Create Post
        $post = Post::create([
            'title' => $this->title,
            'description' => $this->meta_description,
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keyword' => $this->meta_keyword,
            'tags' => $this->tags,
            'image' => $imagePath,
        ]);

        // dd($post); // You can uncomment this now, it should work.

        session()->flash('message', 'Blog post created successfully!');
        return redirect()->route('admin.blogs.index');
    }



    public function render()
    {
        return view('livewire.admin.blogs.blog-create');
    }
}
