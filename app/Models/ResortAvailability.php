<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResortAvailability extends Model
{
    use HasFactory;

    protected $fillable = ['resort_id', 'day', 'opening_time', 'closing_time'];

    public function resort()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
