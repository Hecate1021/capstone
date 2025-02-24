<?php

namespace App\Http\Controllers\Resort; // Ensure this matches the folder structure

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\EventBooking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboard extends Controller // Class name should be capitalized
{


    public function dashboard()
    {
        $user = Auth::user();
        $resortId = $user->id; // The resort_id is the same as the user id

        // Fetch additional statistics for the logged-in resort
        $totalClientsWithBookings = Booking::whereHas('room', function ($query) use ($resortId) {
            $query->where('user_id', $resortId);
        })->distinct('user_id')->count('user_id');

        $totalPayment = Booking::whereHas('room', function ($query) use ($resortId) {
            $query->where('user_id', $resortId);
        })->sum('payment');

        $pendingBookingsCount = Booking::whereHas('room', function ($query) use ($resortId) {
            $query->where('user_id', $resortId);
        })->where('status', 'pending')->count();

        $newBookingsCount = Booking::whereHas('room', function ($query) use ($resortId) {
            $query->where('user_id', $resortId);
        })->where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $eventBooking = EventBooking::where('resort_id', $resortId)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        // Retrieve rooms posted by the authenticated user along with their images
        $rooms = Room::with('images')->where('user_id', $resortId)->get();

        // Daily bookings for the logged-in resort
        $dailyBookings = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->where('rooms.user_id', $resortId)
            ->select(DB::raw('DATE(bookings.created_at) as date'), DB::raw('COUNT(*) as bookings'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Weekly bookings for the logged-in resort
        $weeklyBookings = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->where('rooms.user_id', $resortId)
            ->select(DB::raw('WEEK(bookings.created_at) as week'), DB::raw('COUNT(*) as bookings'))
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Monthly bookings for the logged-in resort
        $monthlyBookings = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->where('rooms.user_id', $resortId)
            ->select(DB::raw('MONTHNAME(bookings.created_at) as month'), DB::raw('COUNT(*) as bookings'))
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(bookings.created_at)'))
            ->get();

        return view('resort.dashboard', compact(
            'user',
            'rooms',
            'totalPayment',
            'pendingBookingsCount',
            'newBookingsCount',
            'totalClientsWithBookings',
            'eventBooking',
            'monthlyBookings',
            'weeklyBookings',
            'dailyBookings'
        ));
    }
}
