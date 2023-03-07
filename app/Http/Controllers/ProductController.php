<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Pricing;
use App\Models\Venue;
use DateInterval;
use DatePeriod;
use DateTime;
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

    public function update($id)
    {
        return view('products.update', [
            'venue' => Venue::find($id),
            'pricings' => Pricing::all(),
        ]);
    }

    public function create()
    {
        $pricings = Pricing::all();
        return view('products.create', ['pricings' => $pricings]);
    }

    public function submit(Request $request)
    {
        $validated = request()->validate([
            'venue_name' => ['string', 'required'],
            'venue_location' => ['string', 'required'],
            'date_start' => ['required'],
            'date_end' => ['required'],
            'capacity' => ['numeric', 'required'],
            'status' => ['string', 'required'],
        ]);

        function getDatesFromRange($start, $end, $format = 'Y-m-d')
        {
            // Declare an empty array
            $array = [];

            // Variable that store the date interval
            // of period 1 day
            $interval = new DateInterval('P1D');

            $realEnd = new DateTime($end);
            $realEnd->add($interval);

            $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

            // Use loop to store date into array
            foreach ($period as $date) {
                $array[] = $date->format($format);
            }

            // Return the array elements
            return $array;
        }

        $date_range = getDatesFromRange(
            $request['date_start'],
            $request['date_end']
        );

        //dd($date_range);

        if ($validated) {
            $venue = Venue::create([
                'venue_name' => $request['venue_name'],
                'venue_location' => $request['venue_location'],
                'date_start' => $request['date_start'],
                'date_end' => $request['date_end'],
            ]);

            if (count(Pricing::all()) == 0) {
                foreach ($request['type'] as $key => $value) {
                    $i = 0;
                    Pricing::create([
                        'type' => $key,
                        'price' => $value[$i],
                    ]);
                    $i++;
                }
            }

            

            foreach ($date_range as $item) {
                Capacity::create([
                    'venue_id' => $venue->id,
                    'max_capacity' => $request['capacity'],
                    'current_capacity' => $request['capacity'],
                    'venue_date' => $item,
                    'status' => $request['status'],
                ]);
            }
        }

        return redirect()
            ->route('product.view')
            ->with('success', 'Venue is successfully created.');
    }

    public function update_venue(Request $request, $id)
    {
        $venue = Venue::find($id);
        $venue->venue_name = $request['venue_name'];
        $venue->venue_location = $request['venue_location'];
        $venue->date_start = $request['date_start'];
        $venue->date_end = $request['date_end'];
        $venue->save();
        return redirect()
            ->route('product.view')
            ->with('success', 'Venue is successfully updated.');
    }
}