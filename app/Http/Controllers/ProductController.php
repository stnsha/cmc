<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Pricing;
use App\Models\Venue;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function view()
    {
        $venues = Venue::all();
        $pricings = Pricing::all();
        return view('products.view', [
            'venues' => $venues,
            'pricings' => $pricings,
        ]);
    }

    public function update()
    {
        return view('products.update');
    }

    public function create()
    {
        return view('products.create');
    }

    public function submit(Request $request)
    {
        // dd($request['type']);
        $validated = request()->validate([
            'venue' => ['string', 'required'],
            'date_start' => ['required'],
            'date_end' => ['required'],
            'capacity' => ['numeric', 'required'],
            'status' => ['string', 'required'],
        ]);

        if ($validated) {
            $venue = Venue::create([
                'venue' => $request['venue'],
                'date_start' => $request['date_start'],
                'date_end' => $request['date_end'],
            ]);

            foreach ($request['type'] as $key => $value) {
                $i = 0;
                Pricing::create([
                    'type' => $key,
                    'price' => $value[$i],
                ]);
                $i++;
            }

            $request['status'] == 1
                ? ($availability = true)
                : ($availability = false);

            Capacity::create([
                'venue_id' => $venue->id,
                'capacity' => $request['capacity'],
                'status' => $request['status'],
                'availability' => $availability,
            ]);

            return redirect()
                ->route('product.view')
                ->with('success', 'Venue is successfully created.');
        }

        //venue
        //pricing
        //capacity
    }
}