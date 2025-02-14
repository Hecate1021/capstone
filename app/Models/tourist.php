<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class tourist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->hasMany(TouristImage::class, 'tourist_id');
    }
}
