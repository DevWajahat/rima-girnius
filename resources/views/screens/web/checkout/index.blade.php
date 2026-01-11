@extends('layouts.web.app')

@section('content')
<div class="min-h-screen bg-[#F8F7F5] py-20 font-['Poppins']">
<div class="container mx-auto px-4 max-w-4xl pt-4">
    {{-- Error Alert --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Success Alert --}}
    @if(session('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
</div>

    <div class="container mx-auto px-4 max-w-4xl">

        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-[#433328]">Checkout</h1>
            <p class="text-gray-500">Review your order before downloading.</p>
        </div>

        <div class="bg-white rounded-lg shadow-xl overflow-hidden flex flex-col md:flex-row">

            {{-- Left: Product Image --}}
            <div class="w-full md:w-1/3 bg-[#262626] flex items-center justify-center p-8">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                         class="w-32 md:w-48 shadow-2xl rounded-sm transform rotate-[-5deg]"
                         alt="{{ $book->title }}">
                @endif
            </div>

            {{-- Right: Order Details --}}
            <div class="w-full md:w-2/3 p-8 md:p-12 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $book->title }}</h2>
                    <p class="text-sm text-gray-500 uppercase tracking-widest mb-6">Digital PDF Edition</p>

                    <div class="border-t border-b border-gray-100 py-4 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ $book->sale_price ?? $book->price }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">$0.00</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-xl font-bold text-[#433328] mb-8">
                        <span>Total</span>
                        <span>${{ $book->sale_price ?? $book->price }}</span>
                    </div>
                </div>

                {{-- Complete Order Button --}}


<form action="{{ route('checkout.process', $book->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn w-full bg-[#5C4B43] ...">
        Pay with PayPal
    </button>
</form>

            </div>
        </div>

    </div>
</div>
@endsection
