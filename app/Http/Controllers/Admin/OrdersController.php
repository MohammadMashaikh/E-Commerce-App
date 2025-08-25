<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    

    public function list()
    {
        $orders = Order::with('user', 'orderItems')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }


    public function approve($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'approved';
        $order->save();

        return redirect()->back()->with('success', 'Order Approved');
    }


    public function decline($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'declined';
        $order->save();

        return redirect()->back()->with('success', 'Order Declined');
    }

}
