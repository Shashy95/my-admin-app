<?php

namespace App\Exports;

use App\Models\Product;

class ProductExport extends BaseExport
{
    public function query()
    {
        $query = Product::query();

        // "Export what I'm looking at": mirrors the DataTable search filter.
        if (! empty($this->filters['search'])) {
            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
        }

        return $query;
    }

    public function headings(): array
    {
        return ['Name', 'SKU', 'Price', 'Stock', 'Status', 'Added'];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->sku,
            $row->price,
            $row->stock,
            $row->status,
            $row->created_at->format('Y-m-d'),
        ];
    }
}
