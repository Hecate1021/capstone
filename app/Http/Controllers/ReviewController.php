<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request,)
    {


        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_id' => 'required',
            'resort_id' => 'required|exists:users,id',
            'review' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
        ]);


        $review = new Review([

            'room_id' => $request->room_id,
            'booking_id' => $request->booking_id,
            'resort_id' => $request->resort_id,
            'user_id' => Auth::id(),
            'review' => $request->review,
            'rating' => $request->rating,
        ]);
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function create($booking_id)
    {
        // Check if the booking exists
        $booking = Booking::findOrFail($booking_id);

        // Check if a review already exists for the given booking_id
        $reviewExists = Review::where('booking_id', $booking_id)->exists();

        if ($reviewExists) {
            // Redirect to the error view
            return view('error');
        }

        // Proceed to the review view if no review exists
        return view('review', compact('booking'));
    }


    public function submit(Request $request, $booking_id)
{
    // Validate the incoming request
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'user_id' => 'nullable',
        'resort_id' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:500',
    ]);

    // Save the review to the database
    $review = new Review();
    $review->room_id = $request->room_id;
    $review->booking_id = $booking_id;
    $review->resort_id = $request->resort_id;
    $review->user_id = $request->user_id;
    $review->review = $request->review;
    $review->rating = $request->rating;
    $review->save();

    // Flash success message to session
    session()->flash('review_success', 'Thank you for your review!');

    // Return response (can redirect to the same page or a different one)
    return redirect()->back();
}



}
