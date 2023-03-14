<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
    ];

    public function pricing(): HasOne
    {
        return $this->hasOne(Pricing::class, 'id', 'pricing_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}