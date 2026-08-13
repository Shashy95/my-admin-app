<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

/**
 * BaseDataTable
 *
 * Extend this per module. You only need to implement:
 *   - query()   -> the base Eloquent/query builder for the table
 *   - columns() -> array of Yajra Column::make() definitions
 *
 * Action buttons (edit/delete) and the export button are added automatically.
 */
abstract class BaseDataTable extends DataTable
{
    /**
     * Base query for the listing. Keep this lean (select only needed columns)
     * -- this is the #1 place people accidentally tank performance by
     * eager-loading relations they don't render in the table.
     */
    abstract public function query();

    /**
     * Column definitions, e.g.:
     *   [Column::make('name'), Column::make('email'), Column::make('created_at')]
     */
    abstract protected function columns(): array;

    /**
     * Route name prefix for this module, e.g. "admin.products".
     * Used to build the edit/delete/export action URLs automatically.
     */
    abstract protected function routePrefix(): string;

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                return view('admin.partials._row-actions', [
                    'row' => $row,
                    'routePrefix' => $this->routePrefix(),
                ])->render();
            })
            ->rawColumns(['action']);
    }

    /**
     * Always returns JSON -- used by the dedicated /data route, which
     * doesn't need render()'s page-vs-ajax detection since this endpoint
     * only ever serves the DataTables JSON payload.
     */
    public function json()
    {
        return $this->dataTable($this->query())->toJson();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId($this->routePrefix() . '-table')
            ->columns($this->tableColumns())
            ->ajax(route("admin.{$this->routePrefix()}.data"))
            ->dom('lfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Appends the action column (edit/delete) to whatever columns() the
     * child module defines.
     */
    protected function tableColumns(): array
    {
        return array_merge(
            $this->columns(),
            [
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(120)
                    ->addClass('text-center'),
            ]
        );
    }

    public function filename(): string
    {
        return $this->routePrefix() . '_' . date('YmdHis');
    }
}
