<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function view()
    {
        return view('choose_venue', [
            'venue' => Venue::all(),
        ]);
    }
}