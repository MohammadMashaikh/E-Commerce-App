<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function list()
    {
        $orders = Order::with('orderItems')->where('user_id', auth()->id())->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::with(['orderItems.product'])->where('user_id', auth()->id())->findOrFail($id);

        return view('orders.show', compact('order'));
    }



    public function json($id)
    {
        $order = Order::with('orderItems.product')
                    ->where('user_id', auth()->id())
                    ->findOrFail($id);

        return response()->json([
            'id' => $order->id,
            'total' => $order->total,
            'orderItems' => $order->orderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'product' => [
                        'name' => $item->product->name ?? 'Deleted Product',
                        'image' => $item->product->getFirstMediaUrl('product-image') ?? 'https://via.placeholder.com/40'
                    ]
                ];
            }),
        ]);
    }


}
