<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\CustomerDetails;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Pricing;
use App\Models\Venue;
use Illuminate\Http\Request;
use Stripe\Price;

class OrderController extends Controller
{
    public function view()
    {
        return view('orders.view', ['orders' => Order::paginate(10)]);
    }

    public function view_order($order_id)
    {
        return view('orders.update', ['order' => Order::find($order_id)]);
    }

    public function order_form($venue_id)
    {
        $venue = Venue::find($venue_id);
        $capacities = Capacity::where('venue_id', $venue_id)->get();
        return view('order_form', [
            'venue' => $venue,
            'capacities' => $capacities,
        ]);
    }

    public function submit_venue(Request $request)
    {
        $venue_details = $request->except('_token', '_method');
        //dd($request['venue_date']);
        //dd($venue_details);
        $pricing_details = [];
        $pricing_details1 = [];
        $pricing_details2 = [];
        $pricing_details3 = [];
        $pricing_details4 = [];
        $total_quantity = 0;
        // dd($request->all());

        $total_quantity =
            $request['adults'] +
            $request['kids_elderly'] +
            $request['kids_free'] +
            $request['kids_pay'] +
            $request['group'];

        //dd($total_quantity);

        if ($total_quantity != 0) {
            if ($request['adults'] > 0) {
                $pricing = Pricing::where('type', 1)->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details = [
                    'pricing_id' => $pricing_id,
                    'price' => $price,
                    'quantity' => $request['adults'],
                    'subtotal' => $price * $request['adults'],
                ];
            }

            if ($request['kids_elderly'] > 0) {
                $pricing = Pricing::where('type', 2)->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details1 = [
                    'pricing_id' => $pricing_id,
                    'price' => $price,
                    'quantity' => $request['kids_elderly'],
                    'subtotal' => $price * $request['kids_elderly'],
                ];
            }

            if ($request['kids_free'] > 0) {
                $pricing = Pricing::where('type', 3)->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details2 = [
                    'pricing_id' => $pricing_id,
                    'price' => $price,
                    'quantity' => $request['kids_free'],
                    'subtotal' => $price * $request['kids_free'],
                ];
            }

            if ($request['kids_pay'] > 0) {
                $pricing = Pricing::where('type', 4)->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details3 = [
                    'pricing_id' => $pricing_id,
                    'price' => $price,
                    'quantity' => $request['kids_pay'],
                    'subtotal' => $price * $request['kids_pay'],
                ];
            }

            if ($request['group'] > 0) {
                $pricing = Pricing::where('type', 5)->first();
                $pricing_id = $pricing->id;
                $price = $pricing->price;
                $pricing_details4 = [
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
                    $pricing_details3,
                    $pricing_details4,
                ];

                //dd($venue_details);

                $request->session()->put('venue_details', $venue_details);

                return redirect()->route('submit_details');
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

    public function submit_details()
    {
        //dd($request->all());
        //dd(session()->get('venue_details'));
        $order_id = 0;
        //is_null($order_id)
        if ($order_id != 0) {
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

            if (count(session()->get('venue_details')[6]) != 0) {
                $pricing = Pricing::where('type', 'Group')->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[6]['price'] *
                    session()->get('venue_details')[6]['quantity'];
                $order_details = OrderDetails::where(
                    'order_id',
                    $request['order_id']
                )
                    ->where('pricing_id', 3)
                    ->first();

                if (!is_null($order_details)) {
                    $order_details->price = session()->get('venue_details')[6][
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
                        'price' => session()->get('venue_details')[6]['price'],
                        'quantity' => session()->get('venue_details')[6][
                            'quantity'
                        ],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            }

            //$service_charge = 0.035 * $total;
            //$total_service = $total + $service_charge;
            $order->total = $total;
            //$order->total = $total_service;
            //$order->service_charge = $service_charge;
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
                'capacity_id' => $capacity->id,
                'date_chosen' => $capacity->venue_date,
                'subtotal' => 0,
                'total' => 0,
            ]);

            for ($i = 2; $i < 7; $i++) {
                if (count(session()->get('venue_details')[$i]) != 0) {
                    $pricing = Pricing::where('type', $i - 1)->first();
                    $pricing_id = $pricing->id;
                    $subtotal =
                        session()->get('venue_details')[$i]['price'] *
                        session()->get('venue_details')[$i]['quantity'];
                    $create_order_details = OrderDetails::create([
                        'order_id' => $create_order->id,
                        'pricing_id' => $pricing_id,
                        'price' => session()->get('venue_details')[$i]['price'],
                        'quantity' => session()->get('venue_details')[$i][
                            'quantity'
                        ],
                        'subtotal' => $subtotal,
                    ]);
                    $total += $subtotal;
                }
            }

            $create_order->total = $total;
            $create_order->save();
            $order_id = $create_order->id;

            return redirect()->route('payment_details', [
                'order_id' => $order_id,
            ]);

            // $create_customer_details = CustomerDetails::create([
            //     'customer_name' => session()->get('venue_details')[0][
            //         'customer_name'
            //     ],
            //     'customer_phone' => session()->get('venue_details')[0][
            //         'customer_phone'
            //     ],
            //     'order_id' => $create_order->id,
            // ]);

            // if (!is_null($request['customer_details'])) {
            //     for ($i = 0; $i < count($request['customer_details']); $i++) {
            //         if ($i % 2 == 0) {
            //             $create_other_customer_details = CustomerDetails::create(
            //                 [
            //                     'customer_name' =>
            //                         $request['customer_details'][$i],
            //                     'customer_phone' =>
            //                         $request['customer_details'][$i + 1],
            //                     'order_id' => $create_order->id,
            //                 ]
            //             );
            //         }
            //     }
            // }

            /*** if (count(session()->get('venue_details')[2]) != 0) {
                $pricing = Pricing::where('type', 1)->first();
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
                $pricing = Pricing::where('type', 2)->first();
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
                $pricing = Pricing::where('type', 3)->first();
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

            if (count(session()->get('venue_details')[5]) != 0) {
                $pricing = Pricing::where('type', 4)->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[5]['price'] *
                    session()->get('venue_details')[5]['quantity'];
                $create_order_details = OrderDetails::create([
                    'order_id' => $create_order->id,
                    'pricing_id' => $pricing_id,
                    'price' => session()->get('venue_details')[5]['price'],
                    'quantity' => session()->get('venue_details')[5][
                        'quantity'
                    ],
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }

            if (count(session()->get('venue_details')[6]) != 0) {
                $pricing = Pricing::where('type', 5)->first();
                $pricing_id = $pricing->id;
                $subtotal =
                    session()->get('venue_details')[6]['price'] *
                    session()->get('venue_details')[6]['quantity'];
                $create_order_details = OrderDetails::create([
                    'order_id' => $create_order->id,
                    'pricing_id' => $pricing_id,
                    'price' => session()->get('venue_details')[6]['price'],
                    'quantity' => session()->get('venue_details')[6][
                        'quantity'
                    ],
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }  ***/

            //$service_charge = 0.035 * $total;
            //$total_service = $total + $service_charge;

            //$create_order->customer_id = $create_customer_details->id;

            //$create_order->service_charge = $service_charge;
            //$create_order->total = $total_service;
        }
    }

    public function payment_details($order_id)
    {
        $order = Order::find($order_id);
        return view('payment_details', ['order' => $order]);
    }

    public function edit_order($order_id)
    {
        $order = Order::find($order_id);
        $venue = Venue::find($order->capacities->venue_id);
        $capacities = Capacity::all();

        $adults = 0;
        $kids_elderly = 0;
        $kids_free = 0;
        $kids_pay = 0;
        $group = 0;

        foreach ($order->order_details as $item) {
            if ($item->pricing_id == 1) {
                $adults = $item->quantity;
            }

            if ($item->pricing_id == 2) {
                $kids_elderly = $item->quantity;
            }

            if ($item->pricing_id == 3) {
                $kids_free = $item->quantity;
            }

            if ($item->pricing_id == 4) {
                $kids_pay = $item->quantity;
            }

            if ($item->pricing_id == 5) {
                $group = $item->quantity;
            }
        }

        return view('edit_order', [
            'order' => $order,
            'venue' => $venue,
            'capacities' => $capacities,
            'adults' => $adults,
            'kids_elderly' => $kids_elderly,
            'kids_free' => $kids_free,
            'kids_pay' => $kids_pay,
            'group' => $group,
        ]);
    }

    public function update_order(Request $request, $order_id)
    {
        //dd($request->all());
        $total = 0;
        $subtotal = 0;
        $order = Order::find($order_id);
        $order->customer_name = $request['customer_name'];
        $order->customer_email = $request['customer_email'];
        $order->customer_phone = $request['customer_phone'];
        $order->capacity_id = $request['venue'];

        $total_quantity = 0;

        $total_quantity =
            $request['adults'] +
            $request['kids_elderly'] +
            $request['kids_free'] +
            $request['kids_pay'] +
            $request['group'];

        $capacity = Capacity::find($order->capacity_id);

        if ($total_quantity > $capacity->current_capacity) {
            return redirect()
                ->route('edit_order', ['order_id' => $order->id])
                ->with(
                    'fail',
                    'Date is no longer available as it exceeds maximum capacity. Please choose different date.'
                );
        } elseif ($total_quantity == 0) {
            return redirect()
                ->route('edit_order', ['order_id' => $order->id])
                ->with('fail', 'Please choose at least 1 pax.');
        } else {
            if ($request['adults'] != 0) {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 1)
                    ->first();
                if (!empty($order_details)) {
                    $subtotal =
                        $request['adults'] * $order_details->pricing->price;
                    $order_details->quantity = $request['adults'];
                    $order_details->price = $order_details->pricing->price;
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $price = Pricing::find(1);
                    $subtotal = $request['adults'] * $price->price;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => 1,
                        'price' => $price->price,
                        'quantity' => $request['adults'],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            } else {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 1)
                    ->first();

                if (!empty($order_details)) {
                    $order_details->delete();
                    $order_details->save();
                }
            }

            if ($request['kids_elderly'] != 0) {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 2)
                    ->first();

                if (!empty($order_details)) {
                    $subtotal =
                        $request['kids_elderly'] *
                        $order_details->pricing->price;

                    $order_details->quantity = $request['kids_elderly'];
                    $order_details->price = $order_details->pricing->price;
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $price = Pricing::find(2);
                    $subtotal = $request['kids_elderly'] * $price->price;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => 1,
                        'price' => $price->price,
                        'quantity' => $request['kids_elderly'],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            } else {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 2)
                    ->first();

                if (!empty($order_details)) {
                    $order_details->delete();
                    $order_details->save();
                }
            }

            if ($request['kids_free'] != 0) {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 3)
                    ->first();

                if (!empty($order_details)) {
                    $subtotal =
                        $request['kids_free'] * $order_details->pricing->price;

                    $order_details->quantity = $request['kids_free'];
                    $order_details->price = $order_details->pricing->price;
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $price = Pricing::find(3);
                    $subtotal = $request['kids_free'] * $price->price;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => 1,
                        'price' => $price->price,
                        'quantity' => $request['kids_free'],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            } else {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 3)
                    ->first();

                if (!empty($order_details)) {
                    $order_details->delete();
                    $order_details->save();
                }
            }

            if ($request['kids_pay'] != 0) {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 4)
                    ->first();

                if (!empty($order_details)) {
                    $subtotal =
                        $request['kids_pay'] * $order_details->pricing->price;

                    $order_details->quantity = $request['kids_pay'];
                    $order_details->price = $order_details->pricing->price;
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $price = Pricing::find(4);
                    $subtotal = $request['kids_pay'] * $price->price;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => 1,
                        'price' => $price->price,
                        'quantity' => $request['kids_pay'],
                        'subtotal' => $subtotal,
                    ]);
                }
                $total += $subtotal;
            } else {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 4)
                    ->first();

                if (!empty($order_details)) {
                    $order_details->delete();
                    $order_details->save();
                }
            }

            if ($request['group'] != 0) {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 5)
                    ->first();

                if (!empty($order_details)) {
                    $subtotal =
                        $request['group'] * $order_details->pricing->price;

                    $order_details->quantity = $request['group'];
                    $order_details->price = $order_details->pricing->price;
                    $order_details->subtotal = $subtotal;
                    $order_details->save();
                } else {
                    $price = Pricing::find(5);
                    $subtotal = $request['group'] * $price->price;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => 1,
                        'price' => $price->price,
                        'quantity' => $request['group'],
                        'subtotal' => $subtotal,
                    ]);
                }

                $total += $subtotal;
            } else {
                $order_details = OrderDetails::where('order_id', $order->id)
                    ->where('pricing_id', 5)
                    ->first();

                if (!empty($order_details)) {
                    $order_details->delete();
                    $order_details->save();
                }
            }
        }
        $order->total = $total;
        $order->save();
        return redirect()->route('payment_details', ['order_id' => $order->id]);
    }

    /**public function update_customer(Request $request, $order_id)
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
        // dd($order->order_details);
            /*foreach ($order->order_details as $item) {
                dd($item->pricing_id == 3 ? 'not exist' : 'exist');
                if ($item->pricing_id == 1 && $request['adults'] != 0) {
                    $price = Pricing::find($item->pricing_id);
                    $subtotal = $price->price * $request['adults'];

                    $item->price = $price->price;
                    $item->quantity = $request['adults'];
                    $item->subtotal = $subtotal;

                    $total += $subtotal;
                    $item->save();
                } elseif (
                    is_null($item->pricing_id) &&
                    $request['adults'] != 0
                ) {
                    $price = Pricing::find($item->pricing_id);
                    $subtotal = $price->price * $request['adults'];

                    $item->price = $price->price;
                    $item->quantity = $request['adults'];
                    $item->subtotal = $subtotal;

                    $total += $subtotal;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => 1,
                        'price' => $price->price,
                        'quantity' => $request['adults'],
                        'subtotal' => $subtotal,
                    ]);
                } else {
                    $item->delete();
                }

                if ($item->pricing_id == 2 && $request['kids_elderly'] != 0) {
                    $price = Pricing::find($item->pricing_id);
                    $subtotal = $price->price * $request['kids_elderly'];

                    $item->price = $price->price;
                    $item->quantity = $request['kids_elderly'];
                    $item->subtotal = $subtotal;

                    $total += $subtotal;
                    $item->save();
                } elseif (
                    is_null($item->pricing_id) &&
                    $request['kids_elderly'] != 0
                ) {
                    $price = Pricing::find($item->pricing_id);
                    $subtotal = $price->price * $request['kids_elderly'];

                    $item->price = $price->price;
                    $item->quantity = $request['kids_elderly'];
                    $item->subtotal = $subtotal;

                    $total += $subtotal;
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'pricing_id' => 1,
                        'price' => $price->price,
                        'quantity' => $request['kids_elderly'],
                        'subtotal' => $subtotal,
                    ]);
                } else {
                    $item->delete();
                }

                /**if ($item->pricing_id == 3 && $request['kids_free'] != 0) {
                $price = Pricing::find($item->pricing_id);
                $subtotal = $price->price * $request['kids_free'];

                $item->price = $price->price;
                $item->quantity = $request['kids_free'];
                $item->subtotal = $subtotal;

                $total += $subtotal;
                $item->save();
            }

            if ($item->pricing_id == 4 && $request['kids_pay'] != 0) {
                $price = Pricing::find($item->pricing_id);
                $subtotal = $price->price * $request['kids_pay'];

                $item->price = $price->price;
                $item->quantity = $request['kids_pay'];
                $item->subtotal = $subtotal;

                $total += $subtotal;
                $item->save();
            } else {
                $item->delete();
            }

            if ($item->pricing_id == 5 && $request['group'] != 0) {
                $price = Pricing::find($item->pricing_id);
                $subtotal = $price->price * $request['group'];

                $item->price = $price->price;
                $item->quantity = $request['group'];
                $item->subtotal = $subtotal;

                $total += $subtotal;
                $item->save();
            } else {
                $item->delete();
            }
    } **/
}