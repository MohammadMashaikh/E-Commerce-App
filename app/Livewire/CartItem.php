<?php

namespace App\Livewire;

use Livewire\Component;

class CartItem extends Component
{
    public $productId;
    public $item;

    public function increase()
    {
        $cart = session('cart', []);
        $cart[$this->productId]['quantity']++;
        session(['cart' => $cart]);

        // Dispatch browser event instead of emit
        $this->dispatch('cart-updated');
    }

    public function decrease()
    {
        $cart = session('cart', []);
        if ($cart[$this->productId]['quantity'] > 1) {
            $cart[$this->productId]['quantity']--;
            session(['cart' => $cart]);
            $this->dispatch('cart-updated');
        }
    }

    public function remove()
    {
        $cart = session('cart', []);
        unset($cart[$this->productId]);
        session(['cart' => $cart]);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart-item');
    }
}
