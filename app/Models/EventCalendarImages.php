<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCalendarImages extends Model
{
    protected $fillable = ['event_calendar_id', 'image', 'path'];

    public function eventCalendar()
    {
        return $this->belongsTo(EventCalendar::class, 'event_calendar_id');
    }
}
