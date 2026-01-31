<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserOrderDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                return '<a href="'.route('user.orders.show', $query->id).'" class="btn btn-primary"><i class="far fa-eye"></i></a>';
            })
            ->editColumn('amount', function($query){
                return $query->currency_icon . $query->amount;
            })
            ->editColumn('created_at', function($query){
                return date('d-M-Y', strtotime($query->created_at));
            })
            ->editColumn('payment_status', function($query){
                if($query->payment_status === 1){
                    return "<span class='badge bg-success'>complete</span>";
                } else {
                    return "<span class='badge bg-warning'>pending</span>";
                }
            })
            ->editColumn('order_status', function($query){
                switch ($query->order_status) {
                    case 'pending':
                        return "<span class='badge bg-warning'>pending</span>";
                    case 'processed_and_ready_to_ship':
                        return "<span class='badge bg-info'>processed</span>";
                    case 'dropped_off':
                        return "<span class='badge bg-info'>dropped off</span>";
                    case 'shipped':
                        return "<span class='badge bg-info'>shipped</span>";
                    case 'out_for_delivery':
                        return "<span class='badge bg-primary'>out for delivery</span>";
                    case 'delivered':
                        return "<span class='badge bg-success'>delivered</span>";
                    case 'canceled':
                        return "<span class='badge bg-danger'>canceled</span>";
                    default:
                        return $query->order_status;
                }
            })
            ->rawColumns(['order_status', 'action', 'payment_status'])
            ->setRowId('id');
    }

    public function query(Order $model): QueryBuilder
    {
        // Correct query syntax to filter by logged-in user
        return $model->newQuery()->where('user_id', Auth::id());
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('userorder-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0)
                    ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            // Column::make('invocie_id')->title('Invoice'),
            Column::make('created_at')->title('Date'),
            Column::make('product_qty')->title('Qty'),
            Column::make('amount')->title('Amount'),
            Column::make('order_status')->title('Order Status'),
            Column::make('payment_status')->title('Payment'),
            
        ];
    }
}