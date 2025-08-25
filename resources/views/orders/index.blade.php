@extends('layouts.master')

@section('content')
<div x-data="orderModal()" x-cloak>
    <h1 class="text-2xl font-bold mb-6 text-gray-800">My Orders</h1>

    @if($orders->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Order #</th>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Date</th>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Items</th>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Total</th>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Status</th>
                    <th class="px-6 py-3 text-center text-gray-600 uppercase text-sm">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($orders as $order)
                <tr>
                    <td class="px-6 py-4 text-gray-800 font-medium">#{{ $order->id }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $order->orderItems->count() }}</td>
                    <td class="px-6 py-4 text-gray-800 font-semibold">${{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-4">
                        @if($order->status === 'pending')
                            <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-semibold">Pending</span>
                        @elseif($order->status === 'approved')
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-sm font-semibold">Approved</span>
                        @elseif($order->status === 'declined')
                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-sm font-semibold">Declined</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button @click="openModal({{ $order->id }})"
                                class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition text-sm">
                            View
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    @else
    <p class="text-gray-600 text-center mt-10">You have no orders yet.</p>
    @endif

    <!-- Modal -->
    <div x-show="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <button @click="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>

            <template x-if="order.id">
                <div>
                    <h2 class="text-xl font-bold mb-4">Order #<span x-text="order.id"></span></h2>

                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Product</th>
                                <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Quantity</th>
                                <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Price</th>
                                <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <template x-for="item in order.orderItems || []" :key="item.id">
                                <tr>
                                    <td class="px-6 py-4 text-gray-800 flex items-center gap-2">
                                        <img :src="item.product.image" :alt="item.product.name" class="w-10 h-10 object-cover rounded border">
                                        <span x-text="item.product.name"></span>
                                    </td>
                                    <td class="px-6 py-4" x-text="item.quantity"></td>
                                    <td class="px-6 py-4">$<span x-text="item.price.toFixed(2)"></span></td>
                                    <td class="px-6 py-4">$<span x-text="(item.price * item.quantity).toFixed(2)"></span></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div class="mt-4 text-right font-bold text-gray-800">
                        Grand Total: $<span x-text="order.total ? order.total.toFixed(2) : '0.00'"></span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
function orderModal() {
    return {
        isOpen: false,
        order: {},
        openModal(orderId) {
            fetch(`/orders/json/${orderId}`)
                .then(res => res.json())
                .then(data => {
                    // Convert total and item prices to numbers
                    data.total = Number(data.total) || 0;
                    data.orderItems = data.orderItems.map(item => {
                        item.price = Number(item.price) || 0;
                        return item;
                    });

                    this.order = data;
                    this.isOpen = true;
                })
                .catch(() => alert('Failed to load order.'));
        },

        closeModal() {
            this.isOpen = false;
            this.order = {};
        }
    }
}
</script>
@endsection
