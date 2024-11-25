<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImages extends Model
{
    use HasFactory;
    protected $fillable = ['events_id', 'image', 'path'];

    // Define the inverse relationship
    // public function event()
    // {
    //     return $this->belongsTo(Events::class);
    // }
    public function event()
    {
        return $this->belongsTo(Events::class, 'events_id');
    }
}
