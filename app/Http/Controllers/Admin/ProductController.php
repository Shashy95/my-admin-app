<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Exports\ProductExport;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Worked example: this whole controller is ~15 lines because
 * BaseCrudController does the heavy lifting. Copy this file when
 * adding a new module -- see docs/ADDING_A_MODULE.md.
 */
class ProductController extends BaseCrudController
{
    protected function modelClass(): string
    {
        return Product::class;
    }

    protected function rules(Request $request): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }

    protected function rulesForUpdate(Request $request, $id): array
    {
        $rules = $this->rules($request);
        $rules['sku'] = "required|string|max:50|unique:products,sku,{$id}";

        return $rules;
    }

    protected function dataTableClass(): string
    {
        return ProductDataTable::class;
    }

    protected function exportClass(): string
    {
        return ProductExport::class;
    }

    protected function viewNamespace(): string
    {
        return 'admin.examples.products';
    }
}
