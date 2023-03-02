<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'user_id',
        'order_details_id',
        'fpx_id',
    ];
}