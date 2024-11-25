<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'resort_id',
        'event_name',
        'description',
        'event_start',
        'event_end',
        'price',
        'discount',
        'image',
        'path',
    ];
    protected $casts = [
        'event_start' => 'datetime',
        'event_end' => 'datetime',
    ];
    public function images()
    {
        return $this->hasMany(EventImages::class);
    }
    public function eventImages()
{
    return $this->hasMany(EventImages::class, 'events_id');
}
public function user()
{
    return $this->belongsTo(User::class);
}
public function owner()
{
    return $this->belongsTo(User::class, 'resort_id');
}
}
