<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">

<!-- Navbar -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-indigo-600">
            <i data-feather="shopping-bag"></i>
            E-Shop
        </a>

        <!-- Links -->
        <div class="flex items-center gap-6">
            <a href="{{ route('home') }}" class="flex items-center gap-1 text-gray-700 hover:text-indigo-600 transition">
                <i data-feather="grid"></i>
                <span>Products</span>
            </a>
           <livewire:cart-icon :key="'cart-icon'" />
            
            @if(auth()->check())
            <a href="{{ route('orders.list') }}" class="relative flex items-center gap-1 text-gray-700 hover:text-indigo-600 transition">
                <i data-feather="list"></i>
                <span>Orders</span>
                @php
                    $ordersCount = \App\Models\Order::where('user_id', auth()->id())->count();
                @endphp
                @if($ordersCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                        {{ $ordersCount }}
                    </span>
                @endif
            </a>

            <span class="text-gray-700 font-medium">Hello, {{ auth()->user()->name }}</span>

            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg">
                   Logout
            </button>
          </form>

        @else
            <a href="{{ route('login') }}" class="bg-green-800 hover:bg-green-700 text-white py-2 px-4 rounded-lg">
                   Login
            </a>
            <a href="{{ route('register') }}" class="bg-green-800 hover:bg-green-700 text-white py-2 px-4 rounded-lg">
                   Register
            </a>
      
            @endif

        </div>
    </div>
</nav>


<!-- Content -->
<div class="max-w-7xl mx-auto px-6 py-6">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
@include('layouts.alert-message')

@livewireScripts
<script>feather.replace();</script>


@yield('custom-js')
</body>
</html>
