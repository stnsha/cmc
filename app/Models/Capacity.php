<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capacity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'venue_id',
        'max_capacity',
        'current_capacity',
        'venue_date',
        'status',
    ];
}