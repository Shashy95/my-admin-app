<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

/**
 * BaseCrudController
 *
 * Extend this for any new admin module (Products, Customers, Orders, etc.)
 * and you get list/create/edit/delete/export wired up for free.
 *
 * A child controller only needs to define:
 *   - model class ($this->modelClass())
 *   - validation rules ($this->rules())
 *   - the DataTable class used for the listing ($this->dataTableClass())
 *   - the export class used ($this->exportClass())
 *
 * See resources/views/admin/examples/products for a full worked example.
 */
abstract class BaseCrudController extends Controller
{
    /**
     * Fully-qualified Eloquent model class for this module.
     */
    abstract protected function modelClass(): string;

    /**
     * Validation rules used for both create and update.
     * Override rulesForUpdate() if update needs different rules (e.g. unique:ignore).
     */
    abstract protected function rules(Request $request): array;

    /**
     * The Yajra DataTable class that powers the listing endpoint.
     */
    abstract protected function dataTableClass(): string;

    /**
     * The Maatwebsite export class used for the "Export" button.
     */
    abstract protected function exportClass(): string;

    /**
     * Blade view namespace for this module, e.g. "admin.examples.products".
     */
    abstract protected function viewNamespace(): string;

    protected function rulesForUpdate(Request $request, $id): array
    {
        return $this->rules($request);
    }

    public function index()
    {
        $dataTableClass = $this->dataTableClass();
        $dataTable = new $dataTableClass;

        return view("{$this->viewNamespace()}.index", compact('dataTable'));
    }

    /**
     * AJAX endpoint consumed by the Yajra DataTable on the index view.
     */
    public function data()
    {
        $dataTableClass = $this->dataTableClass();

        return (new $dataTableClass)->json();
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules($request));

        DB::transaction(function () use ($validated) {
            $this->modelClass()::create($validated);
        });

        return back()->with('success', 'Record created successfully.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $record = $this->modelClass()::findOrFail($id);

        $validated = $request->validate($this->rulesForUpdate($request, $id));

        DB::transaction(function () use ($record, $validated) {
            $record->update($validated);
        });

        return back()->with('success', 'Record updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $record = $this->modelClass()::findOrFail($id);
        $record->delete();

        return back()->with('success', 'Record deleted successfully.');
    }

    /**
     * Streams an Excel or PDF download of the current module's data.
     * Filters from the request (search, date range, etc.) are passed through
     * to the export class so "export what I'm looking at" works out of the box.
     *
     * Usage: /admin/products/export?format=xlsx  or  ?format=pdf  (default: xlsx)
     */
    public function export(Request $request)
    {
        $exportClass = $this->exportClass();
        $format = $request->query('format', 'xlsx');

        $writerType = match ($format) {
            'pdf' => \Maatwebsite\Excel\Excel::DOMPDF,
            'csv' => \Maatwebsite\Excel\Excel::CSV,
            default => \Maatwebsite\Excel\Excel::XLSX,
        };

        $filename = strtolower(class_basename($this->modelClass())) . '-' . now()->format('Y-m-d') . '.' . $format;

        return (new $exportClass($request->all()))->download($filename, $writerType);
    }
}
