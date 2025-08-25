<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }


    public function dashboard()
    {
        $admins_count = Admin::count();
        $orders_count = Order::count();
        $products_count = Product::count();

        $revenue_total = Order::where('status', 'approved')->pluck('total')->toArray();

        $total_revenue_count = 0;
        foreach ($revenue_total as $total) {
            $total_revenue_count += $total;
        }
        
        $recent_orders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('admins_count', 'orders_count' ,'total_revenue_count', 'products_count', 'recent_orders'));
    }   

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
