    

        @extends('admin.layouts.master')

        @section('title', 'Dashboard')


        @section('content')
      <!-- Dashboard Cards -->
      <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Users</h2>
            <p class="text-3xl font-bold mt-2">{{ $admins_count }}</p>
          </div>
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Orders</h2>
            <p class="text-3xl font-bold mt-2">{{ $orders_count }}</p>
          </div>
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Revenue</h2>
            <p class="text-3xl font-bold mt-2">${{ $total_revenue_count }}</p>
          </div>
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Products</h2>
            <p class="text-3xl font-bold mt-2">{{ $products_count }}</p>
          </div>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-2xl mt-8 overflow-hidden">
          <h2 class="text-lg font-semibold p-6 border-b">Recent Orders</h2>
          <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
              <tr>
                <th class="p-4">#</th>
                <th class="p-4">Customer</th>
                <th class="p-4">Amount</th>
                <th class="p-4">Status</th>
              </tr>
            </thead>
            <tbody class="text-gray-700">
              @forelse($recent_orders as $order)
              <tr class="border-b hover:bg-gray-50">
                <td class="p-4">{{ $order->id }}</td>
                <td class="p-4">{{ $order->user->name }}</td>
                <td class="p-4">${{ $order->total }}</td>
                <td class="p-4"><span class="{{ $order->status == 'approved' ? 'bg-green-100 text-green-700' : ($order->status == 'declined' ?  'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')}} px-3 py-1 rounded-full text-sm">{{ ucfirst($order->status) }}</span></td>
             </tr>
             @empty
             <tr><td>No Orders Yet</td></tr>
              @endforelse
              
            </tbody>
          </table>
        </div>
      </main>

    </div>
  </div>

  @endsection


