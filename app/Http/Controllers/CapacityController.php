<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    public function view()
    {
        return view('capacity.view');
    }

    public function view_venue_capacity($venueId)
    {
        $capacities = Capacity::where('venue_id', $venueId);
        return view('capacity.view_venue_capacity', [
            'capacities' => $capacities,
        ]);
    }
}