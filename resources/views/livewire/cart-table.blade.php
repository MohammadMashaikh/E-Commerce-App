<div>
    @if(count($cart) > 0)
        <table class="min-w-full bg-white rounded-lg shadow-md mb-4">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Product</th>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Price</th>
                    <th class="px-6 py-3 text-center text-gray-600 uppercase text-sm">Quantity</th>
                    <th class="px-6 py-3 text-left text-gray-600 uppercase text-sm">Total</th>
                    <th class="px-6 py-3 text-center text-gray-600 uppercase text-sm">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($cart as $productId => $item)
                    @php $total = $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/50' }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded">
                            <span class="text-gray-800 font-medium">{{ $item['name'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">${{ $item['price'] }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="updateQuantity({{ $productId }}, 'decrease')" class="bg-gray-200 text-gray-600 px-2 py-1 rounded hover:bg-gray-300">-</button>
                                <span class="px-2">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity({{ $productId }}, 'increase')" class="bg-gray-200 text-gray-600 px-2 py-1 rounded hover:bg-gray-300">+</button>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-semibold">${{ $total }}</td>
                        <td class="px-6 py-4 text-center">
                            <button wire:click="removeItem({{ $productId }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Remove</button>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50">
                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-800">Grand Total:</td>
                    <td colspan="2" class="px-6 py-4 font-bold text-gray-800">${{ $this->grandTotal }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-center">
            <button wire:click="checkout" class="bg-green-900 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                Checkout
            </button>
        </div>

    @else
        <p class="text-gray-600 text-center mt-10">Your cart is empty.</p>
    @endif

    <!-- Login Modal -->
    <div x-data="{ open: @entangle('showLoginModal') }">
        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96">
                <h2 class="text-xl font-bold mb-4">Please Log In</h2>
                <p class="mb-4">You must log in to proceed with checkout.</p>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Login</a>
                    <button @click="open = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
