@extends('admin.layouts.master')

@section('content')
<div class="m-14 bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-semibold mb-6">Add New User</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Product Name -->
        <div>
            <label for="name" class="block mb-2 font-medium text-gray-700">User Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block mb-2 font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block mb-2 font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" min="8"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block mb-2 font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" min="8"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('password_confirmation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Role -->
        <div>
            <label for="role_id" class="block mb-2 font-medium text-gray-700">Role</label>
            <select name="role_id" id="role_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <!-- Image Upload with Drag & Drop Style -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">User Image</label>
            
            <label for="image" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16V4m0 0L3 8m4-4l4 4m6 8v-8m0 0l-4 4m4-4l4 4"/>
                    </svg>
                    <p class="text-gray-500 text-sm mt-2">Click to upload or drag & drop</p>
                    <p class="text-gray-400 text-xs">PNG, JPG up to 2MB</p>
                </div>
                <input id="image" name="image" type="file" accept="image/*" class="hidden" onchange="previewImages(event)">
            </label>

            @error('image')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror

            <div id="imagePreviewContainer" class="mt-4 grid grid-cols-3 gap-4 hidden">
                <!-- JS will populate preview images here -->
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center">
            <button type="submit"
                    class="px-6 py-2 bg-green-700 text-white font-semibold rounded-lg hover:bg-green-800 transition">
                Add User
            </button>
        </div>
    </form>

</div>
@endsection

