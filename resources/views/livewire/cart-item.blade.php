<tr>
    <td class="px-6 py-4 flex items-center gap-3">
        <img src="{{ $item['image'] ?? 'https://via.placeholder.com/50' }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded">
        <span class="text-gray-800 font-medium">{{ $item['name'] }}</span>
    </td>
    <td class="px-6 py-4 text-gray-700">${{ $item['price'] }}</td>
    <td class="px-6 py-4 text-center">
        <div class="flex items-center justify-center gap-2">
            <button wire:click="decrease" class="bg-gray-200 text-gray-600 px-2 py-1 rounded hover:bg-gray-300">-</button>
            <span class="px-2">{{ $item['quantity'] }}</span>
            <button wire:click="increase" class="bg-gray-200 text-gray-600 px-2 py-1 rounded hover:bg-gray-300">+</button>
        </div>
    </td>
    <td class="px-6 py-4 text-gray-800 font-semibold">${{ $item['price'] * $item['quantity'] }}</td>
    <td class="px-6 py-4 text-center">
        <button wire:click="remove" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Remove</button>
    </td>
</tr>
