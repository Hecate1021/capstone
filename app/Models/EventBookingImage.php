<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBookingImage extends Model
{
    use HasFactory;

    protected $fillable = ['event_booking_id', 'image', 'path'];

    public function eventBooking()
{
    return $this->belongsTo(EventBooking::class, 'event_booking_id');
}

}
