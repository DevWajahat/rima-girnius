<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // <--- This is required
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // --- STANDARD CHECKOUT METHODS ---

    public function index($id)
    {
        $book = Book::findOrFail($id);
        return view('screens.web.checkout.index', compact('book'));
    }

    public function process($id)
    {
        $book = Book::findOrFail($id);
        $price = $book->sale_price ?? $book->price;

        try {
            $returnUrl = route('checkout.success', ['id' => $book->id]);
            $cancelUrl = route('checkout.cancel', ['id' => $book->id]);

            // Call the local private method instead of the service
            $order = $this->createPayPalOrder($price, $returnUrl, $cancelUrl);

            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }

            return back()->with('error', 'PayPal did not return an approval link.');

        } catch (\Exception $e) {
            return back()->with('error', 'PayPal Error: ' . $e->getMessage());
        }
    }

    public function success(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $paypalToken = $request->get('token');

        try {
            // Call the local private method
            $response = $this->capturePayPalPayment($paypalToken);

            if ($response['status'] === 'COMPLETED') {

                Order::create([
                    'user_id' => Auth::id(),
                    'transaction_id' => $response['id'],
                    'status' => 'completed',
                ]);

                session()->flash('message', 'Payment Successful! Downloading...');

                $filename = Str::slug($book->title) . '.pdf';
                return Storage::download($book->pdf, $filename);
            }

        } catch (\Exception $e) {
            return redirect()->route('checkout.index', $id)->with('error', 'Payment Failed: ' . $e->getMessage());
        }

        return redirect()->route('checkout.index', $id)->with('error', 'Payment not completed.');
    }

    public function cancel($id)
    {
        return redirect()->route('checkout.index', $id)->with('error', 'Payment cancelled.');
    }

    // --- PAYPAL LOGIC MOVED HERE (PRIVATE METHODS) ---

    private function getPayPalAccessToken()
    {
        $url = env('PAYPAL_MODE') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';

        $clientId = env('PAYPAL_SANDBOX_CLIENT_ID');
        $secret = env('PAYPAL_SANDBOX_CLIENT_SECRET');

        $response = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post("$url/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('PayPal Auth Failed: ' . $response->body());
    }

    private function createPayPalOrder($amount, $returnUrl, $cancelUrl)
    {
        $url = env('PAYPAL_MODE') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';

        $accessToken = $this->getPayPalAccessToken();

        $response = Http::withToken($accessToken)
            ->post("$url/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => env('PAYPAL_CURRENCY', 'USD'),
                        'value' => number_format($amount, 2, '.', ''),
                    ]
                ]],
                'application_context' => [
                    'return_url' => $returnUrl,
                    'cancel_url' => $cancelUrl,
                    'user_action' => 'PAY_NOW',
                ]
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Create Order Failed: ' . $response->body());
    }

    private function capturePayPalPayment($orderId)
    {
        $url = env('PAYPAL_MODE') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';

        $accessToken = $this->getPayPalAccessToken();

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("$url/v2/checkout/orders/{$orderId}/capture");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Capture Failed: ' . $response->body());
    }
}
