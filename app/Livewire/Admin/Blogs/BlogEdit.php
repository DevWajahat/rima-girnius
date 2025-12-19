<?php

namespace App\Livewire\Admin\Blogs;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogEdit extends Component
{
    use WithFileUploads;

    public Post $post;

    public $title;
    public $content;
    public $meta_title;
    public $meta_description;
    public $meta_keyword;
    public $tags;

    public $new_image;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);

        $this->title = $this->post->title;
        $this->content = $this->post->content;
        $this->meta_title = $this->post->meta_title;
        $this->meta_description = $this->post->meta_description;
        $this->meta_keyword = $this->post->meta_keyword;
        $this->tags = $this->post->tags;
    }

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'meta_title' => 'required|max:100',
            'meta_description' => 'required|max:160',
            'meta_keyword' => 'required|max:255',
            'tags' => 'required|string',
            'new_image' => 'nullable|image|max:2048',
        ];
    }

    public function updatedTitle($value)
    {
        if (!$this->meta_title) {
            $this->meta_title = Str::limit($value, 60);
        }
    }

    public function update($editorContent = null)
    {
        if ($editorContent) {
            $this->content = $editorContent;
        }

        $this->validate();

        $imagePath = $this->post->image;

        if ($this->new_image) {
            if ($this->post->image && Storage::disk('public')->exists($this->post->image)) {
                Storage::disk('public')->delete($this->post->image);
            }
            $imagePath = $this->new_image->store('uploads/blogs', 'public');
        }

        $this->post->update([
            'title' => $this->title,
            'description' => $this->meta_description,
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keyword' => $this->meta_keyword,
            'tags' => $this->tags,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Blog post updated successfully!');
        return redirect()->route('admin.blogs.index');
    }

    public function render()
    {
        return view('livewire.admin.blogs.blog-edit');
    }
}
