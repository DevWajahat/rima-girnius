<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;


class BooksController extends Controller
{
    //
public function index() {
        // Fetch the first published book with its gallery images
        $book = Book::where('is_published', true)->with('images')->first();

        // If no book exists yet, we can handle it gracefully (optional)
        if (!$book) {
            abort(404, 'No books available at the moment.');
        }

        return view('screens.web.books.index', compact('book'));
    }
}
