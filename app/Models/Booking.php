<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['tour_id', 'user_name', 'user_email', 'number_of_people'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
