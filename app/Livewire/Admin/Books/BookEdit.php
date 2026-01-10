<?php

namespace App\Livewire\Admin\Books;

use App\Models\Book;
use App\Models\BookImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookEdit extends Component
{
    use WithFileUploads;

    public $bookId;

    // Form Fields
    public $title;
    public $description;
    public $price;
    public $sale_price;
    public $is_published;

    // File Uploads (Nullable, only populated if user uploads NEW ones)
    public $new_cover_image;
    public $new_pdf_file;

    // Existing Files (For previewing what is currently in DB)
    public $old_cover_image;
    public $old_pdf_file;

    // Gallery Management
    public $existing_gallery_images = []; // Objects from DB
    public $pending_gallery_images = [];  // Array of TemporaryUploadedFile objects
    public $temp_gallery_input = [];      // Temporary bucket for the input field

    public function mount($id)
    {
        $book = Book::findOrFail($id);

        $this->bookId = $book->id;
        $this->title = $book->title;
        $this->description = $book->description;
        $this->price = $book->price;
        $this->sale_price = $book->sale_price;
        $this->is_published = (bool) $book->is_published;

        // Store old paths for preview
        $this->old_cover_image = $book->cover_image;
        $this->old_pdf_file = $book->pdf;

        // Load existing gallery images
        $this->existing_gallery_images = $book->images;
    }

    protected function rules()
    {
        return [
            'title'       => 'required|min:3|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'required|numeric|min:0|lte:price',
            'new_cover_image' => 'nullable|image|max:2048', // Nullable for Edit
            'new_pdf_file'    => 'nullable|mimes:pdf|max:10240', // Nullable for Edit
            'pending_gallery_images.*' => 'image|max:2048',
        ];
    }

    // --- GALLERY LOGIC ---

    // 1. Hook: Merges new input into the pending array
    public function updatedTempGalleryInput()
    {
        if ($this->temp_gallery_input) {
            $this->pending_gallery_images = array_merge($this->pending_gallery_images, $this->temp_gallery_input);
            $this->temp_gallery_input = []; // Reset input
        }
    }

    // 2. Action: Removes a NEW pending image (not saved yet)
    public function removePendingImage($index)
    {
        unset($this->pending_gallery_images[$index]);
        $this->pending_gallery_images = array_values($this->pending_gallery_images);
    }

    // 3. Action: Deletes an EXISTING image from Database
    public function deleteExistingImage($imageId)
    {
        $image = BookImage::findOrFail($imageId);

        // Optional: Delete physical file
        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        // Refresh the list
        $this->existing_gallery_images = BookImage::where('book_id', $this->bookId)->get();
        session()->flash('message', 'Image removed from gallery.');
    }

    // --- SAVE LOGIC ---

    public function update()
    {
        $this->validate();

        $book = Book::findOrFail($this->bookId);

        // 1. Handle Cover Replacement
        if ($this->new_cover_image) {
            // Delete old if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->cover_image = $this->new_cover_image->store('uploads/books/covers', 'public');
        }

        // 2. Handle PDF Replacement
        if ($this->new_pdf_file) {
            // Delete old if exists
            if ($book->pdf) {
                Storage::delete($book->pdf);
            }
            $book->pdf = $this->new_pdf_file->store('books/pdfs');
        }

        // 3. Update Text Fields
        $book->update([
            'title'        => $this->title,
            'description'  => $this->description,
            'price'        => $this->price,
            'sale_price'   => $this->sale_price,
            'is_published' => $this->is_published,
            // cover_image and pdf are auto-updated by Eloquent if we assigned them above,
            // but explicit assignment above works too.
        ]);

        // 4. Save New Gallery Images
        foreach ($this->pending_gallery_images as $photo) {
            $path = $photo->store('uploads/books/gallery', 'public');
            $book->images()->create(['image' => $path]);
        }

        session()->flash('message', 'Book updated successfully!');
        return redirect()->route('admin.books.index');
    }

    public function render()
    {
        return view('livewire.admin.books.book-edit');
    }
}
