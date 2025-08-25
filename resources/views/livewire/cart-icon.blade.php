<a href="{{ route('cart.index') }}" class="relative flex items-center gap-1 text-gray-700 hover:text-indigo-600 transition">
    <i data-feather="shopping-cart"></i>
    <span>Cart</span>
    <span class="ml-1 bg-indigo-600 text-white text-xs px-2 py-0.5 rounded-full">
        {{ $count }}
    </span>
</a>
