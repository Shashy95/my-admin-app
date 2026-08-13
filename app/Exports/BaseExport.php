<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * BaseExport
 *
 * Extend per module. Implement query(), headings(), and map().
 * Filters passed from the controller (search term, date range, etc.)
 * are available via $this->filters so "export current view" works
 * instead of always exporting the full table.
 *
 * Uses the Exportable trait so ->download($filename, $writerType) works
 * directly on the export instance -- see BaseCrudController::export().
 */
abstract class BaseExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Base query, with $this->filters applied (search, date range, etc).
     * Keep this in sync with the DataTable's query() so "what you see is
     * what you export."
     */
    abstract public function query();

    abstract public function headings(): array;

    abstract public function map($row): array;
}
