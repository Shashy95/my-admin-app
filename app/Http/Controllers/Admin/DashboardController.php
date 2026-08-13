<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'inactive_products' => Product::where('status', 'inactive')->count(),
            'low_stock' => Product::where('stock', '<', 10)->count(),
        ];

        $recent = Product::latest()->limit(5)->get();

        // Status breakdown for the doughnut chart
        $statusChart = [
            'labels' => ['Active', 'Inactive'],
            'data' => [$stats['active_products'], $stats['inactive_products']],
        ];

        // Products added per day, last 7 days, for the trend chart
        $last7Days = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->format('Y-m-d'));
        $countsByDay = Product::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->pluck('count', 'day');

        $trendChart = [
            'labels' => $last7Days->map(fn ($d) => \Carbon\Carbon::parse($d)->format('D'))->values(),
            'data' => $last7Days->map(fn ($d) => $countsByDay[$d] ?? 0)->values(),
        ];

        return view('admin.dashboard.index', compact('stats', 'recent', 'statusChart', 'trendChart'));
    }
}
