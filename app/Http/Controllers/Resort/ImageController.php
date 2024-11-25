<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy($id)
    {

    $image = Image::findOrFail($id);

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
