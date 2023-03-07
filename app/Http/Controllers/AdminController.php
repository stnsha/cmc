<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetails;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $total_order = count(Order::all());
        $total_sales = Order::where('status', 'Paid')->sum('total');
        $total_sales = number_format((float) $total_sales, 2, '.', '');
        $total_customers = count(CustomerDetails::all());
        $current_date = Carbon::now();
        return view('admin.dashboard', [
            'total_order' => $total_order,
            'total_sales' => $total_sales,
            'total_customers' => $total_customers,
            'current_date' => $current_date
        ]);
    }
}