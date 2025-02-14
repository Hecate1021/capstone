<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'category_id', 'subcategory_id', 'resort_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function menuImages()
    {
        return $this->hasMany(MenuImage::class); // Assuming one menu can have many images
    }
    public function images()
    {
        return $this->hasMany(MenuImage::class, 'menu_id');
    }
}
