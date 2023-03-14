<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportOrder implements FromView
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $arr_order = [];
        $orders = [];
        $adults = 0;
        $elderly_kids = 0;
        $kid_free = 0;
        $kids_pay = 0;
        $group = 0;

        $order = Order::where('capacity_id', $this->id)
            ->where('status', 'Paid')
            ->get();
        foreach ($order as $item) {
            foreach ($item->order_details as $order_details) {
                if ($order_details->pricing_id == 1) {
                    $adults = $order_details->quantity;
                }
                if ($order_details->pricing_id == 2) {
                    $elderly_kids = $order_details->quantity;
                }
                if ($order_details->pricing_id == 3) {
                    $kid_free = $order_details->quantity;
                }
                if ($order_details->pricing_id == 4) {
                    $kids_pay = $order_details->quantity;
                }
                if ($order_details->pricing_id == 5) {
                    $group = $order_details->quantity;
                }
            }

            $arr_order = [
                'order_id' => $item->id,
                'venue_date' => $item->capacities->venue_date,
                'venue_location' => $item->capacities->venue->venue_name,
                'customer_name' => $item->customer_name,
                'customer_email' => $item->customer_email,
                'customer_phone' => $item->customer_phone,
                'total' => $item->total,
                'status' => $item->status,
                'adults' => $adults,
                'elderly_kids' => $elderly_kids,
                'kid_free' => $kid_free,
                'kid_pay' => $kids_pay,
                'group' => $group,
            ];

            array_push($orders, $arr_order);
        }
        return view('capacity.download', [
            'orders' => $orders,
        ]);
    }
}