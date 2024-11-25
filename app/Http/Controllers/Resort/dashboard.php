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

    // Fetch additional statistics
    $totalClientsWithBookings = Booking::distinct('user_id')->count('user_id');
    $totalPayment = Booking::sum('payment');
    $pendingBookingsCount = Booking::where('status', 'pending')->count();
    $newBookingsCount = Booking::where('created_at', '>=', Carbon::now()->subDays(30))->count();
    $eventBooking = EventBooking::where('created_at', '>=', Carbon::now()->subDays(30))->count();
    $userId = auth()->id();

    // Retrieve rooms posted by the authenticated user along with their images
    $rooms = Room::with('images')->where('user_id', $userId)->get();

    // Count bookings per month
    $dailyBookings = DB::table('bookings')
    ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as bookings'))
    ->groupBy('date')
    ->orderBy('date')
    ->get();

// Weekly bookings data
$weeklyBookings = DB::table('bookings')
    ->select(DB::raw('WEEK(created_at) as week'), DB::raw('COUNT(*) as bookings'))
    ->groupBy('week')
    ->orderBy('week')
    ->get();

// Monthly bookings data
$monthlyBookings = DB::table('bookings')
    ->select(DB::raw('MONTHNAME(created_at) as month'), DB::raw('COUNT(*) as bookings'))
    ->groupBy('month')
    ->orderBy(DB::raw('MONTH(created_at)'))
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
