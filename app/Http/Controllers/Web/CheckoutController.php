<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    // 1. Show the Checkout Page
    public function index($id)
    {
        $book = Book::findOrFail($id);
        return view('screens.web.checkout.index', compact('book'));
    }

    // 2. Process "Order" and Start Download
    public function process($id)
    {
        $book = Book::findOrFail($id);

        // Security Check: Ensure file exists
        if (!Storage::exists($book->pdf)) {
            return back()->with('error', 'File not found. Please contact support.');
        }

        // In a real app, you would save an Order record here.

        // Force Download
        $filename = \Illuminate\Support\Str::slug($book->title) . '.pdf';
        return Storage::download($book->pdf, $filename);
    }
}
