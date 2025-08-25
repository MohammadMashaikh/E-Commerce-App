@extends('layouts.master')

@section('content')

@if (Auth::guard('web')->check() && !Auth::guard('web')->user()->hasVerifiedEmail())
    <div class="flex justify-center bg-cyan-600 p-2 text-white m-6">
        <h3>Please verify your email to be able to order items</h3>
    </div>
@endif


<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
    <h1 class="text-2xl font-bold text-gray-800">Products</h1>

    <!-- Search + Filters -->
    <form action="{{ route('home') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto">
        <input type="text" name="search" placeholder="Search products..."
               value="{{ request('search') }}"
               class="flex-grow md:flex-none px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <select name="sort" onchange="this.form.submit()"
                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            <option value="">Sort by</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
            <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Price: Low → High</option>
            <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Price: High → Low</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i data-feather="search"></i>
        </button>
    </form>
</div>

<!-- Products Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach($products as $product)
        @php
            $image = $product->getFirstMediaUrl('product-image');
        @endphp
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col">
            <img src="{{ $image }}" alt="{{ $product->name }}"
                 class="w-full h-40 object-cover rounded-md">
            <div class="flex-1 mt-3">
                <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                <p class="text-indigo-600 font-bold">${{ $product->price }}</p>
            </div>
            @livewire('add-to-cart', ['product' => $product], key($product->id))
        </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="flex justify-center mt-6">
    {{ $products->appends(request()->query())->links() }}
</div>
@endsection
