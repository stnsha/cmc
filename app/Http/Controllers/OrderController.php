<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\CustomerDetails;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Pricing;
use App\Models\Venue;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order_form()
    {
        $venues = Venue::all();
        $capacities = Capacity::all();
        return view('order_form', [
            'venues' => $venues,
            'capacities' => $capacities,
        ]);
    }

    public function submit_venue(Request $request)
    {
        $venue_details = $request->except('_token', '_method');
        //dd($request['venue_date']);
        // dd($venue_details);
        $pricing_details = [];
        $pricing_details1 = [];
        $pricing_details2 = [];
        $total_quantity = 0;
        // dd($request->all());

        $total_quantity =
            $request['adults'] + $request['kids'] + $request['group'];

        if ($total_quantity != 0) {
            if ($request['adults'] > 0) {
                $pricing = Pricing::where('type', 'Adult')->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details = [
                    'pricing_id' => $pricing_id,
                    'price' => $price,
                    'quantity' => $request['adults'],
                    'subtotal' => $price * $request['adults'],
                ];
            }

            if ($request['kids'] > 0) {
                $pricing = Pricing::where('type', 'Elderly & kids')->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details1 = [
                    'pricing_id' => $pricing_id,
                    'price' => $price,
                    'quantity' => $request['kids'],
                    'subtotal' => $price * $request['kids'],
                ];
            }

            if ($request['group'] > 0) {
                $pricing = Pricing::where('type', 'Group')->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details2 = [
                    'pricing_id' => $pricing_id,
                    'price' => $price,
                    'quantity' => $request['group'],
                    'subtotal' => $price * $request['group'],
                ];
            }

            $capacity = Capacity::find($venue_details['venue']);

            if ($total_quantity > $capacity->current_capacity) {
                return redirect()
                    ->route('order_form')
                    ->with(
                        'fail',
                        'Date is no longer available as it exceeds maximum capacity. Please choose different date.'
                    );
            } else {
                $venue_details = [
                    $venue_details,
                    $total_quantity,
                    $pricing_details,
                    $pricing_details1,
                    $pricing_details2,
                ];

                $request->session()->put('venue_details', $venue_details);

                return redirect()->route('customer_details');
            }
        } else {
            return redirect()
                ->route('order_form')
                ->with('fail', 'Minimum no. of pax is 1. Try again');
        }
    }

    public function customer_details()
    {
        //dd(session()->get('venue_details'));

        $capacity = Capacity::find(session()->get('venue_details')[0]['venue']);

        $venue_date =
            date('d-m-Y l', strtotime($capacity->venue_date)) .
            ' - ' .
            $capacity->venue->venue;

        // dd($venue_date);

        return view('customer_details', [
            'venue_date' => $venue_date,
            'venue_details' => session()->get('venue_details'),
        ]);
    }

    public function submit_details(Request $request)
    {
        //dd($request->all());
        if (!is_null($request['order_id'])) {
            //dd(session()->get('venue_details'));

            $total = 0;
            $order = Order::find($request['order_id']);

            CustomerDetails::where('order_id', $request['order_id'])->delete();

            $create_customer_details = CustomerDetails::create([
                'customer_name' => session()->get('venue_details')[0][
                    'customer_name'
                ],
                'customer_phone' => session()->get('venue_details')[0][
                    'customer_phone'
                ],
                'order_id' => $order->id,
            ]);

            if (!is_null($request['customer_details'])) {
                for ($i = 0; $i < count($request['customer_details']); $i++) {
                    if ($i % 2 == 0) {
                        $create_other_customer_details = CustomerDetails::create(
                            [
                                'customer_name' =>
                                    $request['customer_details'][$i],
                                'customer_phone' =>
                                    $request['customer_details'][$i + 1],
                                'order_id' => $order->id,
                            ]
                        );
                    }
                }
            }

            if (count(session()->get('venue_details')[2]) != 0) {
                $pricing = Pricing::where('type', 'Adult')->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[2]['price'] *
                    session()->get('venue_details')[2]['quantity'];

                $order_details = OrderDetails::where(
                    'order_id',
                    $request['order_id']
                )
                    ->where('pricing_id', 1)
                    ->first();

                if (!is_null($order_details)) {
                    $order_details->price = session()->get('venue_details')[2][
                        'price'
                    ];
                    $order_details->quantity = session()->get(
                        'venue_details'
                    )[2]['quantity'];
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $create_order_details = OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => $pricing_id,
                        'price' => session()->get('venue_details')[2]['price'],
                        'quantity' => session()->get('venue_details')[2][
                            'quantity'
                        ],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            }

            if (count(session()->get('venue_details')[3]) != 0) {
                $pricing = Pricing::where('type', 'Elderly & kids')->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[3]['price'] *
                    session()->get('venue_details')[3]['quantity'];

                $order_details = OrderDetails::where(
                    'order_id',
                    $request['order_id']
                )
                    ->where('pricing_id', 2)
                    ->first();

                if (!is_null($order_details)) {
                    $order_details->price = session()->get('venue_details')[3][
                        'price'
                    ];
                    $order_details->quantity = session()->get(
                        'venue_details'
                    )[3]['quantity'];
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $create_order_details = OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => $pricing_id,
                        'price' => session()->get('venue_details')[3]['price'],
                        'quantity' => session()->get('venue_details')[3][
                            'quantity'
                        ],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            }

            if (count(session()->get('venue_details')[4]) != 0) {
                $pricing = Pricing::where('type', 'Group')->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[4]['price'] *
                    session()->get('venue_details')[4]['quantity'];
                $order_details = OrderDetails::where(
                    'order_id',
                    $request['order_id']
                )
                    ->where('pricing_id', 3)
                    ->first();

                if (!is_null($order_details)) {
                    $order_details->price = session()->get('venue_details')[4][
                        'price'
                    ];
                    $order_details->quantity = session()->get(
                        'venue_details'
                    )[3]['quantity'];
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $create_order_details = OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => $pricing_id,
                        'price' => session()->get('venue_details')[4]['price'],
                        'quantity' => session()->get('venue_details')[4][
                            'quantity'
                        ],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            }

            $service_charge = 0.035 * $total;
            $total_service = $total + $service_charge;
            $order->subtotal = $total;
            $order->total = $total_service;
            $order->service_charge = $service_charge;
            $order->save();
            $order_id = $order->id;
        } else {
            $capacity = Capacity::find(
                session()->get('venue_details')[0]['venue']
            );
            $total = 0;

            $create_order = Order::create([
                'customer_name' => session()->get('venue_details')[0][
                    'customer_name'
                ],
                'customer_phone' => session()->get('venue_details')[0][
                    'customer_phone'
                ],
                'customer_email' => session()->get('venue_details')[0][
                    'customer_email'
                ],
                'venue_id' => $capacity->id,
                'date_chosen' => $capacity->venue_date,
                'subtotal' => 0,
                'total' => 0,
            ]);

            $create_customer_details = CustomerDetails::create([
                'customer_name' => session()->get('venue_details')[0][
                    'customer_name'
                ],
                'customer_phone' => session()->get('venue_details')[0][
                    'customer_phone'
                ],
                'order_id' => $create_order->id,
            ]);

            if (!is_null($request['customer_details'])) {
                for ($i = 0; $i < count($request['customer_details']); $i++) {
                    if ($i % 2 == 0) {
                        $create_other_customer_details = CustomerDetails::create(
                            [
                                'customer_name' =>
                                    $request['customer_details'][$i],
                                'customer_phone' =>
                                    $request['customer_details'][$i + 1],
                                'order_id' => $create_order->id,
                            ]
                        );
                    }
                }
            }

            if (count(session()->get('venue_details')[2]) != 0) {
                $pricing = Pricing::where('type', 'Adult')->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[2]['price'] *
                    session()->get('venue_details')[2]['quantity'];
                $create_order_details = OrderDetails::create([
                    'order_id' => $create_order->id,
                    'pricing_id' => $pricing_id,
                    'price' => session()->get('venue_details')[2]['price'],
                    'quantity' => session()->get('venue_details')[2][
                        'quantity'
                    ],
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }

            if (count(session()->get('venue_details')[3]) != 0) {
                $pricing = Pricing::where('type', 'Elderly & kids')->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[3]['price'] *
                    session()->get('venue_details')[3]['quantity'];
                $create_order_details = OrderDetails::create([
                    'order_id' => $create_order->id,
                    'pricing_id' => $pricing_id,
                    'price' => session()->get('venue_details')[3]['price'],
                    'quantity' => session()->get('venue_details')[3][
                        'quantity'
                    ],
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }

            if (count(session()->get('venue_details')[4]) != 0) {
                $pricing = Pricing::where('type', 'Group')->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[4]['price'] *
                    session()->get('venue_details')[4]['quantity'];
                $create_order_details = OrderDetails::create([
                    'order_id' => $create_order->id,
                    'pricing_id' => $pricing_id,
                    'price' => session()->get('venue_details')[4]['price'],
                    'quantity' => session()->get('venue_details')[4][
                        'quantity'
                    ],
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }

            $service_charge = 0.035 * $total;
            $total_service = $total + $service_charge;
            $create_order->order_details_id = $create_order_details->id;
            $create_order->customer_id = $create_customer_details->id;
            $create_order->subtotal = $total;
            $create_order->service_charge = $service_charge;
            $create_order->total = $total_service;
            $create_order->save();
            $order_id = $create_order->id;
        }

        return redirect()->route('payment_details', [
            'order_id' => $order_id,
        ]);
    }

    public function payment_details($order_id)
    {
        $order = Order::find($order_id);
        return view('payment_details', ['order' => $order]);
    }

    public function edit_order($order_id)
    {
        $order = Order::find($order_id);
        $venues = Venue::all();
        $capacities = Capacity::all();

        foreach ($order->order_details as $item) {
            $item->pricing_id == 1 ? ($adult = $item->quantity) : ($adult = 0);
            $item->pricing_id == 2 ? ($kids = $item->quantity) : ($kids = 0);
            $item->pricing_id == 3 ? ($group = $item->quantity) : ($group = 0);
        }

        return view('edit_order', [
            'order' => $order,
            'venues' => $venues,
            'capacities' => $capacities,
            'adult' => $adult,
            'kids' => $kids,
            'group' => $group,
        ]);
    }

    public function update_customer(Request $request, $order_id)
    {
        $venue_details = $request->except('_token', '_method');
        //$request->session()->flush();
        $pricing_details = [];
        $pricing_details1 = [];
        $pricing_details2 = [];
        $total_quantity = 0;
        // dd($request->all());

        if ($request['adults'] > 0) {
            $pricing = Pricing::where('type', 'Adult')->first();
            $pricing_id = $pricing->id;
            $price = $pricing->price;
            $pricing_details = [
                'pricing_id' => $pricing_id,
                'price' => $price,
                'quantity' => $request['adults'],
                'subtotal' => $price * $request['adults'],
            ];
        }

        if ($request['kids'] > 0) {
            $pricing = Pricing::where('type', 'Elderly & kids')->first();
            $pricing_id = $pricing->id;
            $price = $pricing->price;
            $pricing_details1 = [
                'pricing_id' => $pricing_id,
                'price' => $price,
                'quantity' => $request['kids'],
                'subtotal' => $price * $request['kids'],
            ];
        }

        if ($request['group'] > 0) {
            $pricing = Pricing::where('type', 'Group')->first();
            $pricing_id = $pricing->id;
            $price = $pricing->price;
            $pricing_details2 = [
                'pricing_id' => $pricing_id,
                'price' => $price,
                'quantity' => $request['group'],
                'subtotal' => $price * $request['group'],
            ];
        }

        $total_quantity =
            $request['adults'] + $request['kids'] + $request['group'];

        $venue_details = [
            $venue_details,
            $total_quantity,
            $pricing_details,
            $pricing_details1,
            $pricing_details2,
        ];

        $request->session()->put('venue_details', $venue_details);
        //dd(session()->get('venue_details'));
        // dd($venue_details['adults']);
        $capacity = Capacity::find(session()->get('venue_details')[0]['venue']);

        $venue_date =
            date('d-m-Y l', strtotime($capacity->venue_date)) .
            ' - ' .
            $capacity->venue->venue;

        $existing_customers = [];
        $existing_customers = CustomerDetails::where(
            'order_id',
            $order_id
        )->get();

        $total_customers = 0;
        $total_customers =
            $request['adults'] + $request['kids'] + $request['group'];

        if ($total_customers > count($existing_customers)) {
            $total_customer_after =
                $total_customers - count($existing_customers);
        } else {
            $total_customer_after =
                count($existing_customers) - $total_customers;
        }

        return view('update_customer_details', [
            'total_customers' => $total_customers,
            'existing_customers' => $existing_customers,
            'total_customer_after' => $total_customer_after,
            'venue_date' => $venue_date,
            'venue_details' => $venue_details,
            'order_id' => $order_id,
        ]);
    }
}