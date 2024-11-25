<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\TemporyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadTemporaryImageController extends Controller
{
    public function uploadTempImage(Request $request)
    {
        if($request -> hasFile('image')){
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $folder = uniqid('image-', true);
            $image->storeAs('images/tmp/'. $folder, $filename);

            TemporyImage::create([
                'folder' => $folder,
                'file' => $filename,
            ]);

            return $folder;
        }
        return '';
    }

    public function deleteTempImage()
    {
        $temporaryImage = TemporyImage::where('folder', request()->getContent())->first();
        if($temporaryImage){
            Storage::deleteDirectory('images/tmp/'. $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return response()->noContent();
    }


}
