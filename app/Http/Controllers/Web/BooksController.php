<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Order; // Import Order
use Illuminate\Support\Facades\Auth; // Import Auth
use Illuminate\Support\Facades\Storage; // Import Storage
use Illuminate\Support\Str; // Import Str

class BooksController extends Controller
{
    public function index()
    {
        // 1. Fetch the book
        $book = Book::where('is_published', true)->with('images')->first();

        if (!$book) {
            abort(404, 'No books available at the moment.');
        }

        // 2. Check if User has purchased this book
        $hasPurchased = false;
        if (Auth::check()) {
            // Check for ANY completed order by this user
            // (Since we don't have book_id in orders table yet, this checks if they bought *anything*)
            $hasPurchased = Order::where('user_id', Auth::id())
                ->where('status', 'completed')
                ->exists();
        }

        return view('screens.web.books.index', compact('book', 'hasPurchased'));
    }

    // 3. New Download Method for the Button
    public function download($id)
    {
        $book = Book::findOrFail($id);

        if (!Auth::check()) {
            abort(403, 'You must be logged in.');
        }

        // Verify purchase again for security
        $hasPurchased = Order::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'You have not purchased this book.');
        }

        // Check file existence
        if (!Storage::exists($book->pdf)) {
            abort(404, 'File not found on server.');
        }

        // Download
        $filename = Str::slug($book->title) . '.pdf';
        return Storage::download($book->pdf, $filename);
    }
}
