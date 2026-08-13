@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-lg border p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-700 mb-1">App Name</label>
            <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name']) }}"
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Support Email</label>
            <input type="email" name="support_email" value="{{ old('support_email', $settings['support_email']) }}"
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Low Stock Threshold</label>
            <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', $settings['low_stock_threshold']) }}"
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-500">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
