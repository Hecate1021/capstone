<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $guarderd = [];
    protected $fillable = [
        'user_id',        // Add user_id to fillable attributes
        'contactNo',
        'address',
        'description',
        'profilePhoto',
        'profilePath',
        'coverPhoto',
        'coverPath'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
