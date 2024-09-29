<?php

namespace App\Modules\AppUserBalance\DataTable;

use App\Modules\AppUserBalance\Models\WithdrawLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WithdrawLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_info', function ($row) {
                return "<span>Name: {$row->appUser->name}</span><br><span>ID: {$row->appUser->user_id}</span>";
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<p class="badge bg-info">Pending</p>';
                }
                if ($row->status == 2) {
                    return '<p class="badge bg-success">Accepted</p>';
                }
                if ($row->status == 0) {
                    return '<p class="badge bg-danger">Cancel</p>';
                }
            })
            ->addColumn('action', function ($row) {
                if ($row->status == 1) {
                    return '<div style="display:inline-flex;"><button data-id="' . $row->id . '" class="btn btn-primary btn-sm btn-accept">Accept</button> &nbsp; <button data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-cancel">Cancel</button></div>';
                }
                if ($row->status == 2) {
                    return '';
                    return '<button data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-cancel">Cancel</button></div>';
                }
                if ($row->status == 0) {
                    return '';
                    return '<div style="display:inline-flex;"><button data-id="' . $row->id . '" class="btn btn-primary btn-sm btn-accept">Accept</button></div>';
                }
            })
            ->rawColumns(['user_info', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawLog $model): QueryBuilder
    {
        return $model->with('method');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('withdrawlog-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            // ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                // Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('method.name'),
            Column::make('withdraw_date'),
            Column::make('user_info'),

            Column::make('amount'),
            Column::make('charge'),
            Column::make('total'),
            Column::make('account_no'),
            Column::make('status'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'WithdrawLog_' . date('YmdHis');
    }
}
