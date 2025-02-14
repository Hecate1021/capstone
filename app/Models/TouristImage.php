<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristImage extends Model
{
    use HasFactory;
    protected $fillable = ['tourist_id', 'image', 'path'];
}
