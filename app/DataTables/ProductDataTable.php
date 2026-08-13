<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\Html\Column;

class ProductDataTable extends BaseDataTable
{
    public function dataTable($query)
    {
        return parent::dataTable($query)
            ->editColumn('created_at', fn ($row) => $row->created_at->format('d/m/Y'))
            ->editColumn('status', function ($row) {
                $isActive = $row->status === 'active';
                $dot = $isActive ? 'bg-forest' : 'bg-gray-400';
                $pill = $isActive ? 'bg-forest-50 text-forest-700' : 'bg-gray-100 text-gray-600';

                return '<span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-medium ' . $pill . '">'
                    . '<span class="w-1.5 h-1.5 rounded-full ' . $dot . '"></span>'
                    . ucfirst($row->status)
                    . '</span>';
            })
            ->rawColumns(['status','action']);
    }

    public function query()
    {
        return Product::query()->select(['id', 'name', 'sku', 'price', 'stock', 'status', 'created_at']);
    }

    protected function columns(): array
    {
        return [
            Column::make('name'),
            Column::make('sku')->title('SKU'),
            Column::make('price')->title('Price ($)'),
            Column::make('stock'),
            Column::make('status'),
            Column::make('created_at')->title('Added'),
        ];
    }

    protected function routePrefix(): string
    {
        return 'products';
    }
}
