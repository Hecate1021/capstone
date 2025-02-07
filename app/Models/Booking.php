<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'resort_id',
        'room_id',
        'user_id',
        'name',
        'email',
        'contact_no',
        'number_of_visitors',
        'payment',
        'check_in_date',
        'check_out_date',
        'status',
        'reason',
        ' review_token'
    ];
    protected $dates = ['check_in_date', 'check_out_date'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function paymentRecord()
    {
        return $this->hasOne(PaymentRecord::class, 'booking_id');
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
