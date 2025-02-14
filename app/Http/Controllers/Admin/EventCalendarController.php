<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\EventCalendar;
use App\Models\EventCalendarImages;
use App\Models\TemporyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventCalendarController extends Controller
{
    public function index()
    {
        $eventCalendars = EventCalendar::with(['images', 'user'])->get();
        return view('admin.EventCalendar.event-calendar', compact('eventCalendars'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',

        ]);

        // Get temporary images uploaded in the current session/request
        $temporaryImages = TemporyImage::all(); // Get all temporary images

        if ($validator->fails()) {
            // Delete temporary images on validation failure
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Save Event Calendar
        $event = EventCalendar::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
        ]);

        // Process each temporary image
        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temp to permanent storage
            $destinationPath = 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file;
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                $destinationPath
            );

            // Save image details in EventCalendarImages table
            EventCalendarImages::create([
                'event_calendar_id' => $event->id,
                'image' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);

            // Delete the temporary image and directory
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return redirect()->back()->with('success', 'Event added successfully!');
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',

        ]);

        // Get temporary images uploaded in the current session/request
        $temporaryImages = TemporyImage::all(); // Get all temporary images

        if ($validator->fails()) {
            // Delete temporary images on validation failure
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Save Event Calendar
        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
        ]);



        // Process each temporary image
        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temp to permanent storage
            $destinationPath = 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file;
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                $destinationPath
            );

            // Save image details in EventCalendarImages table
            EventCalendarImages::create([
                'event_calendar_id' => $event->id,
                'image' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);

            // Delete the temporary image and directory
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return redirect()->back()->with('success', 'Event added successfully!');
    }

    public function destroy($id)
    {
        $event = EventCalendar::findOrFail($id);

        // Delete associated images
        $eventImages = EventCalendarImages::where('event_calendar_id', $event->id)->get();
        foreach ($eventImages as $image) {
            Storage::delete('images/' . $image->path); // Delete image from storage
            $image->delete(); // Delete record from database
        }

        // Delete event
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully.');
    }
    public function imagedestroy($id)
    {

        $image = EventCalendarImages::findOrFail($id);

        // Delete the image file from storage
        Storage::delete('images/' . $image->path);

        // Remove the record from the database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully!']);
    }
}
