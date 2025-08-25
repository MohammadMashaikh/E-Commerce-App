@extends('admin.layouts.master')

@section('content')

@can('view-roles', auth('admin')->user())

<!-- Container aligning search/button with table -->
<div class="mx-10 mt-14 flex flex-col md:flex-row items-center justify-between gap-4">
    <!-- Search bar -->
    <form action="{{ route('admin.roles.list') }}" method="GET" class="flex w-full md:w-1/2">
        <input type="text" name="search" placeholder="Search roles..." 
               class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition">
            Search
        </button>
    </form>


    <!-- Add Role button -->
    @can('manage-roles', auth('admin')->user())
    <a href="{{ route('admin.roles.create') }}" 
       class="px-6 py-2 bg-green-800 text-white rounded-lg hover:bg-green-700 transition">
       + Add Role
    </a>
    @endcan
</div>

<!-- Role Table -->
<div class="bg-white shadow-lg rounded-2xl overflow-hidden m-10">
    <h2 class="text-lg font-semibold p-6 border-b">Recent Roles</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[600px]">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="p-4">Name</th>
                    <th class="p-4">Users</th>
                    <th class="p-4">Permissions</th>
                    <th class="p-4">Created Date</th>
                    <th class="p-4">Created Time</th>
                    @can('manage-roles', auth('admin')->user())
                    <th class="p-4">Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($roles as $role)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $role->name }}</td>

                    <td class="p-4">
                        <div class="flex flex-wrap gap-2 min-w-0">
                            @forelse ($role->admins->take(3) as $admin)
                                <button class="px-2 py-1 bg-gray-100 rounded text-sm hover:bg-gray-200">
                                    {{ $admin->name }}
                                </button>
                            @empty
                                N/A
                            @endforelse

                            @if ($role->admins->count() > 3)
                                <button class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-sm hover:bg-blue-200">
                                    +{{ $role->admins->count() - 3 }} more
                                </button>
                            @endif
                        </div>
                    </td>

                    <td class="p-4">
                        <div class="flex flex-wrap gap-2 min-w-0">
                            @forelse ($role->permissions->take(3) as $permission)
                                <button class="px-2 py-1 bg-gray-100 rounded text-sm hover:bg-gray-200">
                                    {{ $permission->name }}
                                </button>
                            @empty
                                N/A
                            @endforelse

                            @if ($role->permissions->count() > 3)
                                <button class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-sm hover:bg-blue-200">
                                    +{{ $role->permissions->count() - 3 }} more
                                </button>
                            @endif
                        </div>
                    </td>


                    <td class="p-4">{{ $role->created_at->format('d M Y') }}</td>
                    <td class="p-4">{{ $role->created_at->format('h:i A') }}</td>

                    @can('manage-roles', auth('admin')->user())
                    @if (!$role->admins->pluck('name')->contains('super-admin'))
                    <td class="p-4 flex gap-2">
                    
                    <a href="{{ route('admin.roles.edit', $role->id) }}" 
                    class="text-blue-600 hover:text-blue-800 transition">
                        <!-- Pencil Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M11 5h2M4 15l4 4L20 7l-4-4-12 12z" />
                        </svg>
                    </a>

                    
                    <form action="{{ route('admin.roles.delete', $role->id) }}" method="POST" onsubmit="confirmation(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 transition">
                            <!-- Trash Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z" />
                            </svg>
                        </button>
                    </form>
                </td>
                @endif
                @endcan
                </tr>

                @empty
                <tr><td class="p-4 text-center text-gray-500" colspan="6">No Available Roles Yet</td></tr>

                @endforelse
            </tbody>
        </table>
    </div>

</div>

<div class="flex justify-center">
    {{ $roles->links() }}
</div>

@else

    <h1 class="text-center mt-10">You Don't Have permissions to view this page</h1>

@endcan

@endsection
