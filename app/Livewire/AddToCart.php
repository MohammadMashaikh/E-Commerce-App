<?php

namespace App\Livewire;

use Livewire\Component;

class AddToCart extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        $cart = session()->get('cart', []);

        $cart[$this->product->id] = [
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => ($cart[$this->product->id]['quantity'] ?? 0) + 1,
            'image' => $this->product->getFirstMediaUrl('product-image'),
        ];

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        $this->dispatch('cart-added'); 
        
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
