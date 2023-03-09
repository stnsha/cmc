<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetails;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerDetailsController extends Controller
{
    public function view()
    {
        return view('admin.customers', [
            'customers' => Order::paginate(10),
        ]);
    }
}