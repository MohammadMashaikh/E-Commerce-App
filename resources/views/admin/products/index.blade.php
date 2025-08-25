@extends('admin.layouts.master')

@section('content')

@can('view-products', auth('admin')->user())


<!-- Container aligning search/button with table -->
<div class="mx-10 mt-14 flex flex-col md:flex-row items-center justify-between gap-4">
    <!-- Search bar -->
    <form action="{{ route('admin.products.list') }}" method="GET" class="flex w-full md:w-1/2">
        <input type="text" name="search" placeholder="Search products..." 
               class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition">
            Search
        </button>
    </form>


    <!-- Add Product button -->
    @can('manage-products', auth('admin')->user())
    <a href="{{ route('admin.products.create') }}" 
       class="px-6 py-2 bg-green-800 text-white rounded-lg hover:bg-green-700 transition">
       + Add Product
    </a>
    @endcan
</div>

<!-- Products Table -->
<div class="bg-white shadow-lg rounded-2xl m-10">
    <h2 class="text-lg font-semibold p-6 border-b">Recent Products</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[600px]">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="p-4">Image</th>
                    <th class="p-4">Product</th>
                    <th class="p-4">Stock</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Created Date</th>
                    <th class="p-4">Created Time</th>
                    @can('manage-products', auth('admin')->user())
                    <th class="p-4">Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">
                        @if($product->hasMedia('product-image'))
                            <img src="{{ $product->getFirstMediaUrl('product-image') }}" 
                                alt="{{ $product->name }}" 
                                class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </td>

                    <td class="p-4">{{ $product->name }}</td>
                    <td class="p-4">{{ $product->stock }}</td>
                    <td class="p-4">${{ $product->price }}</td>
                    <td class="p-4">{{ $product->created_at->format('d M Y') }}</td>
                    <td class="p-4">{{ $product->created_at->format('h:i A') }}</td>
                    @can('manage-products', auth('admin')->user())
                    <td class="p-4 flex gap-2">
                    
                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                    class="text-blue-600 hover:text-blue-800 transition">
                        <!-- Pencil Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M11 5h2M4 15l4 4L20 7l-4-4-12 12z" />
                        </svg>
                    </a>

                    
                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" onsubmit="confirmation(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 transition">
                            <!-- Trash Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z" />
                            </svg>
                        </button>
                    </form>
                </td>
                @endcan

                </tr>
                @empty
                <tr><td class="p-4 text-center text-gray-500" colspan="6">No Available Products Yet</td></tr>

                @endforelse
            </tbody>
        </table>
    </div>

</div>

<div class="flex justify-center">
    {{ $products->links() }}
</div>

@else

    <h1 class="text-center mt-10">You Don't Have permissions to view this page</h1>

@endcan

@endsection
