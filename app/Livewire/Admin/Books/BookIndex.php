<?php

namespace App\Livewire\Admin\Books;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class BookIndex extends Component
{
    use WithPagination;

    // Use Bootstrap 5 pagination theme to match Admin Panel
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Reset page to 1 when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Toggle Sort Order
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Delete (Soft Delete)
    public function delete($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete(); // Soft delete based on your model trait

            session()->flash('message', 'Book moved to trash successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting book: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $books = Book::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.books.book-index', [
            'books' => $books
        ]);
    }
}
