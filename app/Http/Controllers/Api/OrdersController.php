<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrdersController extends Controller
{
    

    public function list()
    {

        $admin = auth('admin-api')->user();

        if (Gate::denies('view-orders', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }

        
        $orders = Order::with('user', 'orderItems')->latest()->paginate(10);

        $data = $orders->map(function ($order) {
            return new OrderResource($order);
        });

        return response()->json([
            'message' => '',
            'success' => true,
            'data' => $data,
        ]);
    }


   public function changeStatus($id, $newStatus)
    {
        $admin = auth('admin-api')->user();

        if (Gate::denies('manage-orders', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }

        $order = Order::findOrFail($id);

        if ($order->status == $newStatus) {
            return response()->json([
                'message' => "Order already {$newStatus}!",
                'success' => false,
                'data' => null
            ]);
        }

        if ($order->status == ($newStatus === 'approved' ? 'declined' : 'approved')) {
            return response()->json([
                'message' => "Order already " . ($order->status) . " before!",
                'success' => false,
                'data' => null
            ]);
        }

        $order->status = $newStatus;
        $order->save();

        return response()->json([
            'message' => "Order {$newStatus} successfully",
            'success' => true,
            'data' => null
        ]);
    }


    public function approve($id)
    {
        return $this->changeStatus($id, 'approved');
    }

    public function decline($id)
    {
        return $this->changeStatus($id, 'declined');
    }



}
