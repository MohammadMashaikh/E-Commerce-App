<?php

namespace App\Livewire;

use App\Mail\OrderPlacedMail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;

class CartTable extends Component
{
    public $cart = [];
    public $showLoginModal = false;

    public function mount()
    {
        // Make sure to load cart from session
        $this->cart = session('cart', []);
    }

    public function updateQuantity($productId, $type)
    {
        if (!isset($this->cart[$productId])) return;

        if ($type === 'increase') {
            $this->cart[$productId]['quantity']++;
        } elseif ($type === 'decrease' && $this->cart[$productId]['quantity'] > 1) {
            $this->cart[$productId]['quantity']--;
        }

        session(['cart' => $this->cart]);
    }

    public function removeItem($productId)
    {
        unset($this->cart[$productId]);
        session(['cart' => $this->cart]);
    }


    public function checkout()
    {
        if (!Auth::check()) {
            $this->showLoginModal = true;
            return;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status' => 'pending',
            'created_at' => now(),
        ]);

        foreach ($this->cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        Mail::to(Auth::user()->email)->queue(new OrderPlacedMail($order));

        $this->cart = [];
        session()->forget('cart');

        return redirect()->route('orders.list')->with('success', 'Order placed successfully!');
    }


    public function render()
    {
        return view('livewire.cart-table', [
            'cart' => $this->cart
        ]);
    }

    public function getGrandTotalProperty()
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }
}
