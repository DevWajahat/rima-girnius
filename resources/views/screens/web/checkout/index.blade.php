@extends('layouts.web.app')

@section('content')
<div class="min-h-screen bg-[#F8F7F5] py-20 font-['Poppins']">
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
                    <button type="submit" class="btn w-full bg-[#5C4B43] hover:bg-[#433328] text-white border-none rounded-full h-14 text-base font-bold uppercase tracking-widest shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        Complete Order & Download
                    </button>
                    <p class="text-xs text-center text-gray-400 mt-3">
                        By clicking above, you agree to our Terms of Service.
                    </p>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
