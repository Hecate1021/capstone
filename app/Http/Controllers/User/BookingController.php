<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\BookingAccept;
use App\Mail\BookingCancelled;
use App\Mail\BookingCheckout;
use App\Mail\BookingDetails;
use App\Mail\BookingDetailsForOwner;
use App\Mail\BookingUserCancel;
use App\Mail\BookingWalkIn;
use App\Models\Booking;
use App\Models\EventBooking;
use App\Models\Image;
use App\Models\PaymentRecord;
use App\Models\Review;
use App\Models\Room;
use App\Models\TemporyImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function booking($id)
    {
        $room = Room::findOrFail($id);
        return view('user.booking', compact('room'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact_no' => 'required|string|max:20',
            'number_of_visitors' => 'required|integer|min:1',
            'payment' => 'required',
            'special_request' => 'required|string', // Changed from 'request'
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
        ]);

        if ($validator->fails()) {
            $temporaryImages = TemporyImage::all();
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $checkInDate = Carbon::createFromFormat('m/d/Y', $request->check_in_date)->format('Y-m-d');
        $checkOutDate = Carbon::createFromFormat('m/d/Y', $request->check_out_date)->format('Y-m-d');

        // Check for overlapping bookings
        $overlappingBooking = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhereRaw('? BETWEEN check_in_date AND check_out_date', [$checkInDate])
                    ->orWhereRaw('? BETWEEN check_in_date AND check_out_date', [$checkOutDate]);
            })
            ->exists();

        if ($overlappingBooking) {
            return redirect()->back()->withErrors(['check_in_date' => 'The room is already booked for the selected dates.'])->withInput();
        }
        // Find the room to get the resort ID
        $room = Room::find($request->room_id);
        if (!$room) {
            return redirect()->back()->withErrors(['room_id' => 'Invalid room selected.'])->withInput();
        }

        // Create a new booking record
        $booking = new Booking();
        $booking->room_id = $request->room_id;
        $booking->user_id = Auth::user()->id;
        $booking->resort_id = $room->user_id; // Add the resort_id here
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->contact_no = $request->contact_no;
        $booking->number_of_visitors = $request->number_of_visitors;
        $booking->payment = $request->payment;
        $booking->request = $request->special_request; // Changed to 'special_request'
        $booking->check_in_date = $checkInDate;
        $booking->check_out_date = $checkOutDate;

        // Save the booking to get its ID
        $booking->save();

        // Handle payment photo upload if exists
        $temporaryImages = TemporyImage::all();
        $imagePath = null;

        foreach ($temporaryImages as $temporaryImage) {
            $finalPath = 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file;
            Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, $finalPath);

            // Create a new PaymentRecord
            $paymentRecord = PaymentRecord::create([
                'booking_id' => $booking->id,
                'payment_name' => $temporaryImage->file,
                'payment_path' => $finalPath
            ]);

            // Save the final path of the image
            $imagePath = $finalPath;

            // Cleanup the temporary directory and delete the temporary image record
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        // Send booking details email to the resort owner and user
        $resortOwner = User::find($room->user_id);
        $currentUser = Auth::user();
        $userEmail = Auth::user()->email;
        if ($resortOwner) {
            // Send email to the resort owner
            Mail::to($resortOwner->email)
                ->send(new BookingDetailsForOwner($booking, $userEmail, $resortOwner));

            // Send email to the booking user
            Mail::to($currentUser->email)
                ->send(new BookingDetails($booking, $currentUser, $resortOwner));
        }

        // Redirect with a success message
        return redirect()->route('success')->with('success', 'Booking created successfully.');
    }



    //Update Details of Booking
    public function updateBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_no' => 'required|string|max:255',
            'payment' => 'required|numeric',
            // 'status' => 'required|in:Pending,Accept,Cancel,Check Out',
        ]);

        $booking->room->update(['name' => $request->room_name]);
        $booking->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'payment' => $request->payment,
            'status' => $request->status,
        ]);

        return redirect()->route('resort.booking')->with('success', 'Booking updated successfully.');
    }
    //Check Out
    public function check_outView(Booking $booking)
    {
        return view('resort.booking.bookingCheckOut', compact('booking'));
    }
    public function check_out(Request $request, Booking $booking)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_no' => 'required|string|max:255',
            'payment' => 'required|numeric',
        ]);

        // Update room name
        $booking->room->update(['name' => $request->room_name]);

        // Update booking details
        $booking->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'payment' => $request->final_payment, // Updated to use the correct input name
            'status' => 'Check Out',
        ]);

        $user = $booking->user; // User who made the booking

        // Get the resort owner (user who posted the room)
        $resortOwner = $booking->room->user; // Assuming 'user' relationship on Room model

        // Send an email to the user from the resort owner's email
        Mail::to($booking->email)->send(new BookingCheckout($booking, $resortOwner, $user));


        return redirect()->route('resort.booking')->with('success', 'Check Out successfully.');
    }



    public function mybooking()
    {
        $user = Auth::user();

        // Fetch room bookings with related data
        $bookings = Booking::with(['room.images', 'room.reviews.user', 'resort.userInfo'])
            ->where('user_id', $user->id)
            ->get();

        // Count status for room bookings
        $pendingCount = $bookings->where('status', 'Pending')->count();
        $acceptCount = $bookings->where('status', 'Accept')->count();
        $reviewCount = $bookings->where('status', 'Check Out')->count();
        $cancelCount = $bookings->where('status', 'Cancel')->count();

        // Create an array to store user reviews for each booking
        $userReviews = [];
        foreach ($bookings as $booking) {
            $userReview = Review::where('user_id', $user->id)
                ->where('booking_id', $booking->id)
                ->first();

            $userReviews[$booking->id] = $userReview;
        }

        // Fetch event bookings with related data
        $eventBookings = EventBooking::with(['event.images', 'resort.userInfo'])
            ->where('user_id', $user->id)
            ->get();

        // Count status for event bookings
        $eventPendingCount = $eventBookings->where('status', 'Pending')->count();
        $eventAcceptCount = $eventBookings->where('status', 'Accept')->count();
        $eventReviewCount = $eventBookings->where('status', 'Check Out')->count();
        $eventCancelCount = $eventBookings->where('status', 'Cancel')->count();

        // Calculate combined counts for the tabs
        $combinedPendingCount = $pendingCount + $eventPendingCount;
        $combinedAcceptCount = $acceptCount + $eventAcceptCount;
        $combinedReviewCount = $reviewCount + $eventReviewCount;
        $combinedCancelCount = $cancelCount + $eventCancelCount;

        return view('user.mybooking', compact(
            'bookings',
            'user',
            'combinedPendingCount',
            'combinedAcceptCount',
            'combinedReviewCount',
            'combinedCancelCount',
            'userReviews',
            'eventBookings'
        ));
    }

    public function bookingUserCancel(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Find the booking by ID
        $booking = Booking::findOrFail($id);


        // Update the booking status to 'Cancelled' and save the reason
        $booking->status = 'Cancel';
        $booking->reason = $request->input('reason');



        $booking->save();



        // Find the associated room and update its status to 'available'
        $room = Room::find($booking->room_id);


        // Get the owner's email from the room's owner
        $resortEmail = $room->owner->email; //  Adjust based on your relationship

        // Get the user's email and name
        $user = auth()->user();
        $userEmail = $user->email;
        $userName = $user->name;

        // Send the cancellation email
        Mail::to($resortEmail)->send(new BookingUserCancel($booking, $request->input('reason'), $userEmail, $userName));

        // Redirect back with a success message
        return redirect()->route('user.mybooking')->with('success', 'Booking cancelled successfully.');
    }

    public function bookingCancel(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Find the booking by ID
        $booking = Booking::findOrFail($id);

        // Update the booking status to 'Cancelled' and save the reason
        $booking->status = 'Cancel';
        $booking->reason = $request->input('reason');
        $booking->save();

        // Find the associated room and update its status to 'available'
        $room = Room::find($booking->room_id);


        // Get the owner's email from the room's owner
        $resortEmail = $room->owner->email; // Adjust based on your relationship

        // Get the user's email and name
        $user = auth()->user();
        $userEmail = $user->email;
        $userName = $user->name;
        $resortOwner = User::find($room->user_id);

        // Send the cancellation email
        Mail::to($userEmail)->send(new BookingCancelled($booking,  $resortOwner));

        // Redirect back with a success message
        return redirect()->route('user.mybooking')->with('success', 'Booking cancelled successfully.');
    }
    public function calendar()
    {
        // Fetch all bookings from the current month onwards
        $bookings = Booking::with('user', 'room')
            ->where('check_in_date', '>=', now()->startOfMonth())
            ->get();

        // Function to generate random colors
        function getRandomColor()
        {
            $colors = ['#ff5733', '#33ff57', '#3357ff', '#ff33a8', '#f4a261', '#2a9d8f', '#e9c46a', '#f94144', '#06d6a0'];
            return $colors[array_rand($colors)];
        }

        // Prepare bookings data for the calendar
        $formattedBookings = $bookings->map(function ($booking) {
            return [
                'title' => $booking->room->name . ' - ' . $booking->user->name,
                'start' => Carbon::parse($booking->check_in_date)->format('Y-m-d'),
                'end' => Carbon::parse($booking->check_out_date)->addDay()->format('Y-m-d'),
                'color' => getRandomColor(), // Assign a random color
            ];
        });

        return view('resort.booking.calendar', compact('formattedBookings', 'bookings'));
    }


    public function getEvents()
    {
        $bookings = Booking::with('room')->get();

        $events = $bookings->map(function ($booking) {
            if ($booking->room) {
                return [
                    'title' => $booking->room->name,
                    'start' => $booking->check_in_date,
                    'end' => Carbon::parse($booking->check_out_date)->addDay()->toDateString(),
                    'color' => $this->getStatusColor($booking->status),
                ];
            }
            return null;
        })->filter()->values();

        Log::info($events); // Log the events for debugging

        return response()->json($events);
    }


    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Accept':
                return 'green';
            case 'Pending':
                return 'orange';
            case 'Cancel':
                return 'red';
            case 'Check Out':
                return 'yellow';
            default:
                return 'gray';
        }
    }

    public function bookingAccept($id)
    {
        // Retrieve the booking by its ID
        $booking = Booking::find($id);

        // Check if the booking exists
        if ($booking) {
            // Update the booking status to 'Accept'
            $booking->update([
                'status' => 'Accept',
            ]);

            // Retrieve the user associated with the booking
            $user = $booking->user; // Assumes you have a relationship defined on the Booking model

            // Get the resort owner (user who posted the room)
            $resortOwner = $booking->room->user; // Assuming 'user' relationship on Room model

            // Send an email to the user
            Mail::to($booking->email)->send(new BookingAccept($booking, $user, $resortOwner));

            return redirect()->route('resort.booking')->with('success', 'Booking accepted successfully.');
        } else {
            return redirect()->route('resort.booking')->with('error', 'Booking not found.');
        }
    }


    public function bookingstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact_no' => 'required|string|max:20',
            'number_of_visitors' => 'required|integer|min:1',
            'payment' => 'required|numeric',
            'request' => 'required|string|max:255',
            'check_in_date' => 'required|date_format:m/d/Y',
            'check_out_date' => 'required|date_format:m/d/Y|after_or_equal:check_in_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $room = Room::find($request->room_id);
        if (!$room) {
            return redirect()->back()->withErrors(['room_id' => 'Invalid room selected.'])->withInput();
        }

        // Convert dates to Carbon instances and adjust time for check-out
        $checkInDate = Carbon::createFromFormat('m/d/Y', $request->check_in_date)->startOfDay();
        $checkOutDate = Carbon::createFromFormat('m/d/Y', $request->check_out_date)->setTime(14, 0); // Check-out ends at 2 PM

        // Check for overlapping bookings
        $overlappingBooking = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                        $query->where('check_in_date', '<=', $checkInDate)
                            ->where('check_out_date', '>=', $checkOutDate);
                    });
            })
            ->exists();

        if ($overlappingBooking) {
            return redirect()->back()->withErrors(['room_id' => 'The room is already booked for the selected dates.'])->withInput();
        }

        // Create the booking
        $booking = new Booking();
        $booking->room_id = $request->room_id;
        $booking->user_id = null;
        $booking->resort_id = $room->user_id;
        $booking->name = $request->name;
        $booking->email = $request->email; // Store the user's email
        $booking->contact_no = $request->contact_no;
        $booking->number_of_visitors = $request->number_of_visitors;
        $booking->payment = $request->payment;
        $booking->check_in_date = $checkInDate;
        $booking->check_out_date = $checkOutDate;
        $booking->request = $request->input('request', 'No special request');
        $booking->status = 'Accept';
        // Save the booking
        $booking->save();

        // Get the resort owner's email
        $resortOwner = User::find($room->user_id);
        $userEmail = $request->email; // The email entered in the booking form

        if ($resortOwner) {
            // Send email to the booking user
            Mail::to($userEmail) // Use the email from the request directly
                ->send(new BookingDetails($booking, $resortOwner, $userEmail)); // Send the email with booking details
        }

        return redirect()->route('resort.booking')->with('success', 'Booking added successfully. ');
    }


    public function cancelBooking(Request $request, $id)
    {


        // Validate the request
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Find the booking by ID
        $booking = Booking::findOrFail($id);

        // Update the booking status to 'Cancelled' and save the reason
        $booking->status = 'Cancel'; // Corrected to 'Cancelled'
        $booking->reason = $request->input('reason');
        $booking->save();

        // Retrieve the room associated with the booking
        $room = Room::find($booking->room_id); // Assuming the booking has a room_id field

        // Retrieve the resort owner's email based on the room's user_id
        $resortOwner = User::find($room->user_id);

        // Get the user's email from the booking instance
        $userEmail = $booking->email; // Use the email stored in the booking

        if ($resortOwner) {
            // Send email to the booking user
            Mail::to($userEmail) // Use the email from the booking directly
                ->send(new BookingCancelled($booking, $resortOwner)); // Pass the resort owner's email
        }

        return redirect()->back()->with('success', 'Booking was canceled successfully and an email notification has been sent.');
    }


    public function success()
    {
        return view('successBooking');
    }
}
