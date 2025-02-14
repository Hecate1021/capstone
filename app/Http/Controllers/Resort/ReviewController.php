<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user
        $user = auth()->user();

        // Fetch reviews that belong to the user's resort (where resort_id matches user id)
        $reviews = Review::with('user') // Eager load the user relationship
            ->where('resort_id', $user->id) // Filter reviews based on the authenticated user's resort_id
            ->get();

        // Pass the data to the view
        return view('resort.review.review', compact('reviews'));
    }

}
