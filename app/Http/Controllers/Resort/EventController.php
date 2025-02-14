<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\EventImages;
use App\Models\Events;
use App\Models\Image;
use App\Models\TemporyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function event()
    {
        $user = Auth::user();
        $resortId = $user->id; // The resort_id is the same as the user id

        // Fetch only events belonging to the logged-in resort
        $events = Events::with('eventImages')->where('resort_id', $resortId)->get();

        return view('resort.event.event', compact('events'));
    }

    public function store(Request $request)
    {
        // Validate the event data
        $validator = Validator::make($request->all(), [
            'resort_id' => 'required',
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_start' => 'required|date',
            'event_end' => 'required|date|after_or_equal:event_start',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $temporaryImages = TemporyImage::all(); // Get all temporary images

        if ($validator->fails()) {
            // Delete temporary images on validation failure
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the event without image data (since images are stored in a separate table)
        $event = Events::create([
            'resort_id' => $request->input('resort_id'),
            'event_name' => $request->input('event_name'),
            'description' => $request->input('description'),
            'event_start' => $request->input('event_start'),
            'event_end' => $request->input('event_end'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
        ]);

        // Move and store images in the eventImages table
        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temp to permanent storage
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            // Create an event image record associated with the event
            EventImages::create([
                'events_id' => $event->id, // Associate with the newly created event
                'image' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);

            // Clean up temporary image
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return redirect()->back()->with('success', 'Event added successfully!');
    }

    public function destroyImages($id)
    {
        $image = EventImages::findOrFail($id);
        Storage::delete('images/' . $image->path); // Delete the image file from storage
        $image->delete(); // Delete the record from the database

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $event = Events::findOrFail($id);
        $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_start' => 'required|date',
            'event_end' => 'required|date',
            'price' => 'required|numeric',
        ]);

        $event->update([
            'event_name' => $request->event_name,
            'description' => $request->description,
            'event_start' => $request->event_start,
            'event_end' => $request->event_end,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Event updated successfully!');
    }

    // Delete event
    public function destroy($id)
    {
        $event = Events::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully!');
    }

    public function imagedestroy($id)
    {
        $image = EventImages::findOrFail($id);

        // Delete the image file
        Storage::delete('images/' . $image->path);

        // Delete the directory if it is empty
        $folderPath = dirname('images/' . $image->path);
        if (count(Storage::files($folderPath)) === 0) {
            Storage::deleteDirectory($folderPath);
        }

        // Delete the image record from the database
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
}
