<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    use HasFactory;
    protected $table = 'event_bookings';

    protected $fillable = [
        'resort_id',
        'event_id',
        'user_id',
        'name',
        'email',
        'contact',
        'payment',
        'image',
        'reason'
    ];

    public function event()
    {
        return $this->belongsTo(Events::class); // Assuming the event model is Event
    }

    public function images()
{
    return $this->hasMany(EventBookingImage::class, 'event_booking_id');
}

public function resortUser()
{
    return $this->belongsTo(User::class, 'id');
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function resort()
{
    return $this->belongsTo(User::class, 'resort_id');
}
}
