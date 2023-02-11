<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'order_id',
        'pricing_id',
        'price',
        'quantity',
        'subtotal',
        'status',
        'venue_id',
        'date_chosen',
        'fpx_id',
    ];
}