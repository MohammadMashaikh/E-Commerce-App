<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Sidebar toggle for mobile
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('-translate-x-full');
    }
  </script>
</head>
<body class="bg-gray-100 font-sans">

  <div class="flex h-screen overflow-y-auto">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white fixed inset-y-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
      <div class="flex items-center justify-center h-16 border-b border-gray-700">
        <span class="text-2xl font-bold">⚡ Admin</span>
      </div>
      <nav class="p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
          📊 <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.users.list') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
          👤 <span>Users</span>
        </a>
        <a href="{{ route('admin.products.list') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
          🛒 <span>Products</span>
        </a>
        <a href="{{ route('admin.roles.list') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.roles.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
          👥 <span>Roles & Permissions</span>
        </a>
        <a href="{{ route('admin.orders.list') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
          📦 <span>Orders</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition">
          📈 <span>Reports</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition">
          ⚙️ <span>Settings</span>
        </a>
      </nav>
      <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg">
                   Logout
            </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col md:ml-64">

      <!-- Top Navbar -->
      <header class="flex items-center justify-between bg-white shadow px-4 py-3 md:px-6">
        <button class="md:hidden text-gray-600 text-2xl" onclick="toggleSidebar()">☰</button>
        <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
        <div class="flex items-center space-x-4">
          <span class="text-gray-600">Hi, {{ auth('admin')->user()->name }}</span>
          <img src="{{ auth()->user()->getFirstMediaUrl('admin-user-image') }}" class="w-10 h-10 rounded-full border" alt="Admin Avatar">
        </div>
      </header>

    @yield('content')

    </div>
  </div>

  </body>
</html>


    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>


  <script>
  function previewImages(event) {
      const container = document.getElementById('imagePreviewContainer');
      const files = event.target.files;
      container.innerHTML = '';
      if(files.length > 0) container.classList.remove('hidden');

      Array.from(files).forEach(file => {
          const reader = new FileReader();
          reader.onload = function(e) {
              const img = document.createElement('img');
              img.src = e.target.result;
              img.className = 'w-full h-32 object-cover rounded-lg shadow';
              container.appendChild(img);
          };
          reader.readAsDataURL(file);
      });
  }
  </script>



    @yield('custom-js')

    @include('admin.layouts.alert-message')
    @include('admin.layouts.confirmation-message')

   



</body>
</html>