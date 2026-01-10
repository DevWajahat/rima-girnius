<?php

namespace App\Livewire\Admin\Books;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $price;
    public $sale_price;
    public $cover_image;
    public $pdf_file;
    public $is_published = true;

    // --- CHANGED SECTION ---
    public $gallery_images = [];      // Holds the final list of files
    public $new_gallery_images = [];  // Temporary holder for the input
    // -----------------------

    protected $rules = [
        'title'            => 'required|min:3|max:255',
        'description'      => 'nullable|string',
        'price'            => 'required|numeric|min:0',
        'sale_price'       => 'required|numeric|min:0|lte:price',
        'cover_image'      => 'required|image|max:2048',
        'pdf_file'         => 'required|mimes:pdf|max:10240',
        'gallery_images.*' => 'image|max:2048', // Validate the main array
    ];

    // 1. Hook: Runs automatically when user selects files
    public function updatedNewGalleryImages()
    {
        // Check if files were actually selected
        if ($this->new_gallery_images) {
            // Merge new files into the main array
            $this->gallery_images = array_merge($this->gallery_images, $this->new_gallery_images);

            // Clear the temporary property so the input is ready for more
            $this->new_gallery_images = [];
        }
    }

    // 2. Action: Removes a specific image from the list
    public function removeGalleryImage($index)
    {
        // Remove item at index
        unset($this->gallery_images[$index]);

        // Re-index array (0, 1, 2...) so Livewire doesn't get confused
        $this->gallery_images = array_values($this->gallery_images);
    }

    public function save()
    {
        $this->validate();

        $coverPath = $this->cover_image->store('uploads/books/covers', 'public');
        $pdfPath   = $this->pdf_file->store('books/pdfs');

        $book = Book::create([
            'title'         => $this->title,
            'description'   => $this->description,
            'price'         => $this->price,
            'sale_price'    => $this->sale_price,
            'cover_image'   => $coverPath,
            'pdf'           => $pdfPath, // Correct column name
            'is_published'  => $this->is_published,
        ]);

        // Iterate over the accumulated $gallery_images
        foreach ($this->gallery_images as $image) {
            $path = $image->store('uploads/books/gallery', 'public');

            $book->images()->create([
                'image' => $path, // Correct column name
            ]);
        }

        session()->flash('message', 'Book and gallery images uploaded successfully!');
        return redirect()->route('admin.books.index');
    }

    public function render()
    {
        return view('livewire.admin.books.book-create');
    }
}
