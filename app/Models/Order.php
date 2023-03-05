<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_id',
        'user_id',
        'order_details_id',
        'subtotal',
        'service_charge',
        'total',
        'venue_id',
        'date_chosen',
        'fpx_id',
        'status',
    ];

    public function order_details(): HasMany
    {
        return $this->HasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(CustomerDetails::class, 'order_id', 'id');
    }

    public function capacities(): HasOne
    {
        return $this->hasOne(Capacity::class, 'venue_id', 'venue_id');
    }
}