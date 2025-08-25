@extends('admin.layouts.master')

@section('content')

@can('view-orders', auth('admin')->user())

<!-- Orders Table -->
<div class="bg-white shadow-lg rounded-2xl m-10">
    <h2 class="text-lg font-semibold p-6 border-b">Recent Orders</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[600px]">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="p-4">Order Image</th>
                    <th class="p-4">Order User Name</th>
                    <th class="p-4">Order User Email</th>
                    <th class="p-4">Product</th>
                    <th class="p-4">Order Items</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Created Date</th>
                    <th class="p-4">Created Time</th>
                    @can('manage-orders', auth('admin')->user())
                    <th class="p-4">Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    
                    <td class="p-4">
                        @if($order->orderItems->count() > 0 && $order->orderItems->first()->product->hasMedia('product-image'))
                            <img src="{{ $order->orderItems->first()->product->getFirstMediaUrl('product-image') }}" 
                                alt="{{ $order->orderItems->first()->product->name }}" 
                                class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </td>

                   
                    <td class="p-4">{{ $order->user->name }}</td>
                    <td class="p-4">{{ $order->user->email }}</td>

                    
                    <td class="p-4">
                        <div class="flex flex-col gap-1">
                            @foreach($order->orderItems as $item)
                                <span>{{ $item->product->name }}</span>
                            @endforeach
                        </div>
                    </td>

                    
                    <td class="p-4">
                        <div class="flex flex-col gap-1">
                            @foreach($order->orderItems as $item)
                                <span>{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</span>
                            @endforeach
                        </div>
                    </td>

                    
                    <td class="p-4">${{ number_format($order->total, 2) }}</td>

                    
                    <td class="p-4">{{ ucfirst($order->status) }}</td>

                    
                    <td class="p-4">{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</td>
                    <td class="p-4">{{ $order->created_at ? $order->created_at->format('h:i A') : 'N/A'  }}</td>

                    
                    @can('manage-orders', auth('admin')->user())
                    @if ($order->status == 'pending')
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('admin.orders.approve', $order->id) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Approve</a>
                        <a href="{{ route('admin.orders.decline', $order->id) }}" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Decline</a>
                    </td>
                    @else
                    <td class="p-4"><span class="{{ $order->status == 'approved' ?  'text-green-700 bg-green-100 ' : 'text-red-700 bg-red-100 ' }}  px-3 py-1 rounded-full text-sm">{{ ucfirst($order->status) }}</span></td>
                    @endif
                    @endcan

                </tr>
                @empty
                <tr>
                    <td class="p-4 text-center text-gray-500" colspan="10">No Available Orders Yet</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

<div class="flex justify-center">
    {{ $orders->links() }}
</div>

@else

    <h1 class="text-center mt-10">You Don't Have permissions to view this page</h1>

@endcan

@endsection
