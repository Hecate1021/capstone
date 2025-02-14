<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Post;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use App\Models\User;

class ResortController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $isOwner = true;

        // Fetch reviews for the authenticated user and calculate the average rating
        $averageRating = Review::where('resort_id', $user->id)->avg('rating');

        // Ensure the average rating does not exceed 5
        $averageRating = min($averageRating, 5);

        // Fetch posts for the authenticated user with their associated files
        $posts = Post::where('user_id', $user->id)->with('files')->get();

        return view('resort.resort-profile', compact('user', 'isOwner', 'averageRating', 'posts'));
    }

    public function create(): View
    {
        return view('resort.resort-register');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('balai');
    }

    //booking
    public function booking(Request $request)
    {
        $user = Auth::user();
        $resortId = $user->id; // The resort_id is the same as the user id

        $query = Booking::whereHas('room', function ($q) use ($resortId) {
            $q->where('user_id', $resortId);
        });

        // Filtering by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Get the number of items per page from the request or default to 10
        $itemsPerPage = $request->input('items_per_page', 10);

        // Define the custom order for the status
        $statusOrder = "'Pending', 'Accept', 'Check Out', 'Cancel'"; // Add any other statuses as needed

        // Sort bookings by status first, then by created_at for latest to oldest
        $bookings = $query->with('room')
            ->orderByRaw("FIELD(status, $statusOrder) ASC") // Order by status as specified
            ->orderBy('created_at', 'DESC') // Order by created_at for latest to oldest
            ->paginate($itemsPerPage);

        // Add a unique identifier to each booking
        $bookings->getCollection()->transform(function ($booking, $index) {
            $booking->unique_id = 'booking-' . $index;
            return $booking;
        });

        return view('resort.resort-booking', compact('bookings', 'itemsPerPage'));
    }






    public function bookingShow(Booking $booking)
    {

        return view('resort.booking.bookingDetails', compact('booking'));
    }
    public function addbooking()
    {
        $rooms = Room::all();
        return view('resort.booking.addBooking', compact('rooms'));
    }
}
