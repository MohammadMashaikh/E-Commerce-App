<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('shop.cart', compact('cart', 'total'));
    }

    
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = $request->session()->get('cart', []);

       
        if(isset($cart[$id])){
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->getFirstMediaUrl('product-image')
            ];
        }

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', $product->name.' added to cart!');
    }

    
    public function update(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        if(isset($cart[$id])){
            $quantity = max(1, (int)$request->quantity);
            $cart[$id]['quantity'] = $quantity;
            $request->session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

   
    public function remove(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => count($request->session()->get('cart', []))
        ]);
    }


    
    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

}
