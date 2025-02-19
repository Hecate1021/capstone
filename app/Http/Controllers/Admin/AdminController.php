<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemporyImage;
use App\Models\tourist;
use App\Models\TouristImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function index()
    {
        // Count the number of users based on roles
        $resortCount = User::where('role', 'resort')->count();
        $userCount = User::where('role', 'user')->count();

        // Get resorts with their average ratings
        $resortRatings = User::where('role', 'resort')
            ->withAvg('reviews', 'rating')
            ->get(['id', 'name']);


        // Paginate resorts and users (10 per page)
        $resorts = User::where('role', 'resort')->paginate(10);
        $users = User::where('role', 'user')->paginate(10);

        return view('admin.admin-dashboard', compact('resortCount', 'userCount', 'resortRatings', 'resorts', 'users'));
    }


    public function tourist()
    {
        $touristSpots = Tourist::with('images')->get(); // Fetch tourist spots with their images
        return view('admin.TouristSpot.tourist-spot', compact('touristSpots'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
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
        // Save Tourist Spot
        $tourist = tourist::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
        ]);

        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temp to permanent storage
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            TouristImage::create([
                'tourist_id' => $tourist->id, // Associate with the newly created event
                'image' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);

            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();

            return redirect()->back()->with('success', 'Tourist Spot added successfully!');
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
        ]);

        $touristSpot = Tourist::findOrFail($id);

        $temporaryImages = TemporyImage::all(); // Get all temporary images

        if ($validator->fails()) {
            // Delete temporary images on validation failure
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update Tourist Spot details
        $touristSpot->update([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
        ]);

        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temp to permanent storage
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            TouristImage::create([
                'tourist_id' => $touristSpot->id, // Associate with the updated tourist spot
                'image' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);

            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return redirect()->back()->with('success', 'Tourist Spot updated successfully!');
    }
    public function imagedestroy($id)
    {

        $image = TouristImage::findOrFail($id);

        // Delete the image file from storage
        Storage::delete('images/' . $image->path);

        // Remove the record from the database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully!']);
    }
    public function destroy($id)
    {
        $touristSpot = tourist::findOrFail($id);

        // Delete associated images from storage
        foreach ($touristSpot->images as $image) {
            $imagePath = storage_path('app/public/images/' . $image->path);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Remove the file
            }
            $image->delete(); // Remove the image record from the database
        }

        // Delete the tourist spot
        $touristSpot->delete();

        return redirect()->back()->with('success', 'Tourist Spot deleted successfully.');
    }

    public function userlist()
    {
        $users = User::where('email', 'like', '%@gmail.com')
            ->where('role', 'user') // Filter only users with role 'user'
            ->get(['name', 'email', 'role', 'email_verified_at']);

        return view('admin.userlists', compact('users'));
    }


    public function resortlist()
    {
        $resorts = User::where('role', 'resort')
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->leftJoin('reviews', 'users.id', '=', 'reviews.resort_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'user_infos.contactNo',
                'user_infos.address',
                \DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating')
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'user_infos.contactNo', 'user_infos.address')
            ->get();

        return view('admin.resortlist', compact('resorts'));
    }
}
