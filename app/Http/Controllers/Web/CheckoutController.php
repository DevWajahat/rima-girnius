<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order; // Your Order Model
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient; // <--- The Package
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // 1. Show the Checkout Page
    public function index($id)
    {
        $book = Book::findOrFail($id);
        return view('screens.web.checkout.index', compact('book'));
    }

    // 2. Process Transaction (Redirect to PayPal)
    public function process($id)
    {
        $book = Book::findOrFail($id);
        $price = $book->sale_price ?? $book->price; // Dynamic Price

        try {
            // Initialize the Package
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            // Create Order
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('checkout.success', ['id' => $book->id]), // Dynamic Return URL
                    "cancel_url" => route('checkout.cancel', ['id' => $book->id]),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($price, 2, '.', '') // Format: 10.00
                        ]
                    ]
                ]
            ]);

            // Redirect to PayPal Approval Link
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
            }

            return redirect()->route('checkout.index', $id)->with('error', 'Something went wrong with PayPal.');

        } catch (\Exception $e) {
            return redirect()->route('checkout.index', $id)->with('error', $e->getMessage());
        }
    }

    // 3. Success Transaction (Capture & Download)
// ... keep index, process, cancel methods exactly as they were ...

    // UPDATE THIS METHOD
    public function success(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {

                // 1. Create Order
                $order = Order::create([
                    'user_id'        => Auth::id(),
                    'transaction_id' => $response['id'],
                    'book_id'        => $book->id, // <--- ADD THIS LINE
                    'status'         => 'completed',
                ]);

                // 2. INSTEAD OF DOWNLOADING, REDIRECT TO SUCCESS PAGE
                // We pass both book_id and order_id because your orders table doesn't have book_id
                return redirect()->route('checkout.thankyou', [
                    'book_id' => $book->id,
                    'order_id' => $order->id
                ]);
            }

            return redirect()->route('checkout.index', $id)
                ->with('error', $response['message'] ?? 'Payment not completed.');

        } catch (\Exception $e) {
            return redirect()->route('checkout.index', $id)->with('error', 'System Error: ' . $e->getMessage());
        }
    }

    // ADD THIS NEW METHOD (The Page)
    public function thankYou($book_id, $order_id)
    {
        $order = Order::findOrFail($order_id);

        // Security: Ensure the logged-in user owns this order
        if(Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('screens.web.checkout.success', [
            'order' => $order,
            'bookId' => $book_id
        ]);
    }

    // ADD THIS NEW METHOD (The File)
    public function downloadPDF($book_id, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $book = Book::findOrFail($book_id);

        // Security Check
        if(Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }

        if (!Storage::exists($book->pdf)) {
            abort(404, 'File not found');
        }

        $filename = Str::slug($book->title) . '.pdf';
        return Storage::download($book->pdf, $filename);
    }



    // 4. Cancel Transaction
    public function cancel($id)
    {
        return redirect()->route('checkout.index', $id)->with('error', 'You have canceled the transaction.');
    }
}
