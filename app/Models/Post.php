<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded =[];
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
    ];
    public function files()
    {
        return $this->hasMany(File::class);
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}
}
