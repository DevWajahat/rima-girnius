<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayPalService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->baseUrl = env('PAYPAL_MODE') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';

        $this->clientId = env('PAYPAL_SANDBOX_CLIENT_ID');
        $this->clientSecret = env('PAYPAL_SANDBOX_CLIENT_SECRET');
    }

    /**
     * 1. Get Access Token (OAuth 2.0)
     */
    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('PayPal Auth Failed: ' . $response->body());
    }

    /**
     * 2. Create Order
     */
    public function createOrder($amount, $returnUrl, $cancelUrl)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => env('PAYPAL_CURRENCY', 'USD'),
                        'value' => number_format($amount, 2, '.', ''), // Ensure format 10.00
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

    /**
     * 3. Capture Payment
     */
    public function capturePayment($orderId)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Capture Payment Failed: ' . $response->body());
    }
}
