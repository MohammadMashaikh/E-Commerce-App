<?php

namespace App\Livewire;

use Livewire\Component;

class CartIcon extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.cart-icon', [
            'count' => count(session()->get('cart', []))
        ]);
    }
}
