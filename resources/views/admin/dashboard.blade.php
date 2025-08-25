    

        @extends('admin.layouts.master')

        @section('title', 'Dashboard')


        @section('content')
      <!-- Dashboard Cards -->
      <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Users</h2>
            <p class="text-3xl font-bold mt-2">1,245</p>
          </div>
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Orders</h2>
            <p class="text-3xl font-bold mt-2">320</p>
          </div>
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Revenue</h2>
            <p class="text-3xl font-bold mt-2">$12,430</p>
          </div>
          <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
            <h2 class="text-gray-500">Products</h2>
            <p class="text-3xl font-bold mt-2">58</p>
          </div>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-2xl mt-8 overflow-hidden">
          <h2 class="text-lg font-semibold p-6 border-b">Recent Orders</h2>
          <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
              <tr>
                <th class="p-4">Order ID</th>
                <th class="p-4">Customer</th>
                <th class="p-4">Amount</th>
                <th class="p-4">Status</th>
              </tr>
            </thead>
            <tbody class="text-gray-700">
              <tr class="border-b hover:bg-gray-50">
                <td class="p-4">#1024</td>
                <td class="p-4">John Doe</td>
                <td class="p-4">$120</td>
                <td class="p-4"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Completed</span></td>
              </tr>
              <tr class="border-b hover:bg-gray-50">
                <td class="p-4">#1025</td>
                <td class="p-4">Jane Smith</td>
                <td class="p-4">$75</td>
                <td class="p-4"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pending</span></td>
              </tr>
              <tr class="border-b hover:bg-gray-50">
                <td class="p-4">#1026</td>
                <td class="p-4">Michael Lee</td>
                <td class="p-4">$340</td>
                <td class="p-4"><span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Cancelled</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>

    </div>
  </div>

  @endsection


