<div>
    @dump($showModal, $order)

    @if($showModal && $order)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <h2 class="text-xl font-bold mb-4">Order #{{ $order->id }}</h2>

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
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 text-gray-800 flex items-center gap-2">
                            <img src="{{ $item->product->getFirstMediaUrl('product-image')}}" 
                                 alt="{{ $item->product->name ?? 'Deleted Product' }}" 
                                 class="w-10 h-10 object-cover rounded border">
                            {{ $item->product->name ?? 'Deleted Product' }}
                        </td>
                        <td class="px-6 py-4">{{ $item->quantity }}</td>
                        <td class="px-6 py-4">${{ number_format($item->price, 2) }}</td>
                        <td class="px-6 py-4">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 text-right font-bold text-gray-800">
                Grand Total: ${{ number_format($order->total, 2) }}
            </div>

            <button wire:click="close" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                &times;
            </button>
        </div>
    </div>
    @endif
</div>
