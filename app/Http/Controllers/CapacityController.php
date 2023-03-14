<?php

namespace App\Http\Controllers;

use App\Exports\ExportOrder;
use App\Models\Capacity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CapacityController extends Controller
{
    public function view($id)
    {
        return view('capacity.view', [
            'capacities' => Capacity::where('venue_id', $id)->get(),
        ]);
    }

    public function view_venue_capacity($venueId)
    {
        return view('capacity.view', [
            'capacities' => Capacity::where('venue_id', $venueId)->paginate(10),
        ]);
    }

    public function update($id)
    {
        return view('capacity.update', [
            'capacity' => Capacity::find($id),
        ]);
    }

    public function update_capacity(Request $request, $id)
    {
        $capacity = Capacity::find($id);
        $capacity->max_capacity = $request['max_capacity'];
        $capacity->status = $request['status'];
        $capacity->save();

        return redirect()->route('capacity.view_venue_capacity', [
            'venue_id' => $capacity->venue_id,
            'capacities' => Capacity::where(
                'venue_id',
                $capacity->venue_id
            )->paginate(10),
        ]);
    }

    public function download_excel($id)
    {
        return Excel::download(new ExportOrder($id), 'orders.xlsx');
    }
}