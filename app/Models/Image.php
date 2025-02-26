<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded =[];
    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
