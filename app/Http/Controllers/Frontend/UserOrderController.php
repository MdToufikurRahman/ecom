<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\DataTables\UserOrderDataTable;
use App\Models\Order;

class UserOrderController extends Controller
{
    public function index(UserOrderDataTable $dataTable)
    {
        return $dataTable->render('frontend.dashboard.order.index');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('frontend.dashboard.order.show', compact('order'));
    }
}