<?php

namespace App\Http\Controllers;

use App\Models\CustomerDetails;
use Illuminate\Http\Request;

class CustomerDetailsController extends Controller
{
    public function view()
    {
        return view('admin.customers', [
            'customers' => CustomerDetails::paginate(10),
        ]);
    }
}