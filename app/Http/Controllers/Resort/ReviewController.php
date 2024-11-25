<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::with('user')->get(); // Eager load user relationship

        return view('resort.review.review', compact('reviews'));
    }
}
