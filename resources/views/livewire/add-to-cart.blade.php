<div x-data="{ added: false }" 
     x-init="@this.on('cart-added', () => { added = true; setTimeout(() => added = false, 2000) })"
     class="flex flex-col items-start gap-2 w-full">

    <!-- Add to Cart Button -->
    <button wire:click="addToCart" 
            wire:loading.attr="disabled"
            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 flex items-center justify-center gap-2 text-sm transition">
        
        <!-- Normal state -->
        <span wire:loading.remove wire:target="addToCart" class="flex items-center gap-2">
            <i data-feather="shopping-cart" class="w-5 h-5"></i>
            Add to Cart
        </span>

        <!-- Loading state -->
        <span wire:loading wire:target="addToCart" class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            Adding...
        </span>
    </button>

    <!-- Success message -->
    <div x-show="added" 
         x-transition
         class="flex items-center gap-2 text-green-600 font-semibold text-sm mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
        </svg>
        Added to Cart
    </div>
</div>
