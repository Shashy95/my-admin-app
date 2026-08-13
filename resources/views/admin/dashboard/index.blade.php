@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg border p-5">
            <p class="text-sm text-gray-500">Total Products</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $stats['total_products'] }}</p>
        </div>
        <div class="bg-white rounded-lg border p-5">
            <p class="text-sm text-gray-500">Active</p>
            <p class="text-2xl font-semibold text-green-600 mt-1">{{ $stats['active_products'] }}</p>
        </div>
        <div class="bg-white rounded-lg border p-5">
            <p class="text-sm text-gray-500">Inactive</p>
            <p class="text-2xl font-semibold text-gray-400 mt-1">{{ $stats['inactive_products'] }}</p>
        </div>
        <div class="bg-white rounded-lg border p-5">
            <p class="text-sm text-gray-500">Low Stock (&lt; 10)</p>
            <p class="text-2xl font-semibold text-amber-600 mt-1">{{ $stats['low_stock'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white rounded-lg border p-5">
            <h2 class="text-sm font-semibold text-gray-900 mb-4">Products Added (Last 7 Days)</h2>
            <canvas id="trendChart" height="110"></canvas>
        </div>
        <div class="bg-white rounded-lg border p-5">
            <h2 class="text-sm font-semibold text-gray-900 mb-4">Status Breakdown</h2>
            <canvas id="statusChart" height="110"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-lg border">
        <div class="px-5 py-4 border-b">
            <h2 class="text-sm font-semibold text-gray-900">Recently Added</h2>
        </div>
        <ul class="divide-y">
            @forelse ($recent as $product)
                <li class="px-5 py-3 flex justify-between items-center text-sm">
                    <span class="text-gray-800">{{ $product->name }}</span>
                    <span class="text-gray-400">{{ $product->created_at->format('d/m/Y') }}</span>
                </li>
            @empty
                <li class="px-5 py-6 text-sm text-gray-400 text-center">No products yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels: @json($trendChart['labels']),
            datasets: [{
                label: 'Products added',
                data: @json($trendChart['data']),
                backgroundColor: '#2F6F4E',
                borderRadius: 4,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($statusChart['labels']),
            datasets: [{
                data: @json($statusChart['data']),
                backgroundColor: ['#2F6F4E', '#d1d5db'],
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush
