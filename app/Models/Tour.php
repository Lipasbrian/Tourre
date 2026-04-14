<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['name', 'description', 'price', 'total_slots', 'available_slots'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
