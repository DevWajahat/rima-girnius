@extends('layouts.web.app')

@section('content')
<div class="min-h-screen bg-[#F8F7F5] py-20 font-['Poppins'] flex items-center justify-center">
    <div class="bg-white p-10 rounded-lg shadow-xl text-center max-w-lg w-full">

        {{-- Success Icon --}}
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-4xl text-green-600"></i>
        </div>

        <h1 class="text-3xl font-bold text-[#433328] mb-4">Payment Successful!</h1>
        <p class="text-gray-600 mb-8">
            Thank you for your purchase. Your transaction ID is <br>
            <span class="font-mono bg-gray-100 px-2 py-1 rounded text-sm text-black">{{ $order->transaction_id }}</span>
        </p>

        <div class="space-y-4">
            <p class="text-sm text-gray-500">Your download should start automatically...</p>

            {{-- Manual Download Button (Backup) --}}
            <a href="{{ route('checkout.download.pdf', ['book_id' => $bookId, 'order_id' => $order->id]) }}"
               class="btn bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full px-8 py-3 text-sm font-bold uppercase tracking-widest shadow-lg transition-all block w-full">
                Click here if download doesn't start
            </a>

            <a href="{{ url('/') }}" class="block text-sm text-gray-400 hover:text-[#5C4B43] mt-4">
                Return to Home
            </a>
        </div>
    </div>
</div>

{{-- Auto-Download Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            window.location.href = "{{ route('checkout.download.pdf', ['book_id' => $bookId, 'order_id' => $order->id]) }}";
        }, 1500); // Wait 1.5 seconds, then download
    });
</script>
@endsection
