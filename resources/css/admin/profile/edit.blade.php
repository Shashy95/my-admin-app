@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-xl space-y-6">

    <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white rounded-lg border p-6 space-y-4">
        @csrf
        @method('PUT')

        <h2 class="text-sm font-semibold text-gray-900">Profile Information</h2>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-500">
                Save Changes
            </button>
        </div>
    </form>

    <form action="{{ route('admin.profile.password') }}" method="POST" class="bg-white rounded-lg border p-6 space-y-4">
        @csrf
        @method('PUT')

        <h2 class="text-sm font-semibold text-gray-900">Change Password</h2>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Current Password</label>
            <input type="password" name="current_password" required
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">New Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-500">
                Update Password
            </button>
        </div>
    </form>
</div>
@endsection
