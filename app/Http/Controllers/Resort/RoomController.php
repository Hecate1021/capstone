<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Image;
use App\Models\Review;
use App\Models\Room;
use App\Models\TemporyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function room()
    {
        $user = Auth::user();
        $isOwner = true;
        // Fetch reviews for the authenticated user and calculate the average rating
        $averageRating = Review::where('resort_id', $user->id)->avg('rating');

        // Ensure the average rating does not exceed 5
        $averageRating = min($averageRating, 5);
        // Get the authenticated user's ID
        $userId = auth()->id();
        // Retrieve rooms posted by the authenticated user along with their images
        $rooms = Room::with('images')->where('user_id', $userId)->get();
        return view('resort.rooms.room', compact('user', 'rooms', 'isOwner', 'averageRating'));
    }

    public function create()
    {
        return view('resort.rooms.add-room');
    }
    public function edit($id)
    {
        $user = Auth::user();
        $room = Room::with('images')->findOrFail($id);

        return view('resort.rooms.room-edit', compact('room'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        //images
        $temporaryImages = TemporyImage::all();
        if ($validator->fails()) {

            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect('/')->withErrors($validator)->withInput();
        }
        // Create the Room instance but do not save it yet
        $room = new Room($validator->validated());
        $room->user_id = Auth::user()->id;

        // Save the Room instance
        $room->save();

        //copy image from tempImage to Images
        foreach ($temporaryImages as $temporaryImage) {
            Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file);
            Image::create([
                'rooms_id' => $room->id,
                'name' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return redirect('resort/room');
    }

    public function update(Request $request, $id)
    {
        // Fetch the existing Room instance
        $room = Room::findOrFail($id);

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        // Get all temporary images
        $temporaryImages = TemporyImage::all();

        if ($validator->fails()) {
            // Cleanup temporary images if validation fails
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update room details with validated data
        $room->update($validator->validated());

        // Handle images
        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temporary storage to the final location
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            // Create a new image record
            Image::create([
                'rooms_id' => $room->id,
                'name' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file,
            ]);

            // Cleanup the temporary directory and delete the temporary image record
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        // Redirect back with success message
        return redirect()->route('resort.room')->with('success', 'Room updated successfully.');
    }
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        // Delete associated images
        foreach ($room->images as $image) {
            Storage::delete('images/' . $image->path);
            Storage::deleteDirectory('images/' . dirname($image->path));
            $image->delete();
        }

        // Delete the room
        $room->delete();

        return redirect()->back()->with('success', 'Room and associated images deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        $roomIds = $request->input('room_ids');
        $status = $request->input('status');

        if ($roomIds && in_array($status, ['online', 'offline'])) {
            // Update the status of the rooms
            Room::whereIn('id', $roomIds)->update(['status' => $status]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
    public function registration($id)
{
    $userId = auth()->id();

    // Fetch the rooms where user_id matches the authenticated user
    $rooms = Room::where('user_id', $userId)->get();

    // Fetch the booking details along with the room ID
    $booking = Booking::find($id);

    // Get the booked room ID
    $bookedRoomId = $booking->room_id;

    return view('resort.registrationForm', compact('booking', 'rooms', 'bookedRoomId'));
}

}
