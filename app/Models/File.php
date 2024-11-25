<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'file_name',
        'file_path',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
