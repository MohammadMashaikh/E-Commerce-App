@extends('admin.layouts.master')

@section('content')
<div class="mt-10 m-14 bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Create New Role</h2>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
            <input type="text" name="name" id="name"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   required>
        </div>

         @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
         @enderror

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($permissions as $permission)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm">{{ $permission->name }}</span>
                    </label>
                @endforeach

                @error('permissions')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-10 flex justify-center">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Create Role
            </button>
        </div>
    </form>
</div>
@endsection
