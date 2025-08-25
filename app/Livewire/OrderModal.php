<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderModal extends Component
{
    public $order;
    public $showModal = false;

    protected $listeners = ['viewOrder' => 'open'];

    public function open($orderId)
    {
        $this->order = Order::with('orderItems.product')->where('user_id', auth()->id())->findOrFail($orderId);

        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->order = null;
    }

    public function render()
    {
        return view('livewire.order-modal');
    }
}
