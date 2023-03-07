<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'venue_name',
        'venue_location',
        'date_start',
        'date_end',
    ];

    public function capacity(): HasOne
    {
        return $this->HasOne(Capacity::class, 'venue_id', 'id');
    }
}