<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuImage;
use App\Models\Subcategory;
use App\Models\TemporyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $resortId = auth()->id(); // Get the authenticated user's ID

        // Retrieve only the menus of the authenticated user's resort
        $menus = Menu::with(['category', 'subcategory', 'menuImages'])
            ->where('resort_id', $resortId)
            ->get();

        // Retrieve only the categories belonging to the authenticated user's resort
        $categories = Category::where('resort_id', $resortId)->get();

        // Retrieve only the subcategories belonging to the authenticated user's resort
        $subcategories = Subcategory::where('resort_id', $resortId)->get();

        return view('resort.menus.menus', compact('menus', 'categories', 'subcategories'));
    }





    // Store a new menuuse Illuminate\Support\Facades\Validator;

    public function store(Request $request)
    {
        // Manually create a validator instance
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            // Get all temporary images
            $temporaryImages = TemporyImage::all();

            // Delete temporary images on validation failure
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            // Redirect back with errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed with storing the menu if validation passes
        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'resort_id' => auth()->id(),

        ]);

        // Handle the temporary images and move them to the permanent storage
        $temporaryImages = TemporyImage::all();
        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temp to permanent storage
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            // Create a menu image record associated with the menu
            MenuImage::create([
                'menu_id' => $menu->id, // Associate with the newly created menu
                'image' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);

            // Clean up temporary image
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        // Redirect to the menu listing page with a success message
        return redirect()->route('resort.menus')->with('success', 'Menu created successfully.');
    }


    public function imagedestroy($id)
    {
        $image = MenuImage::findOrFail($id);

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

    public function destroy($id)
    {
        // Find the menu item by ID
        $menu = Menu::findOrFail($id);

        // Optionally, delete associated images or perform other cleanup

        // Delete the menu item
        $menu->delete();

        // Redirect or return response
        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        // Find the menu item by ID
        $menu = Menu::findOrFail($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // If validation fails, delete temporary images and return with errors
        if ($validator->fails()) {
            $temporaryImages = TemporyImage::all();
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update menu details
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ]);

        // Handle new images (if any)
        $temporaryImages = TemporyImage::all();
        if ($temporaryImages->isNotEmpty()) {
            // Delete old images from storage and database
            $oldImages = $menu->images;
            foreach ($oldImages as $oldImage) {
                Storage::delete('images/' . $oldImage->path);
                $oldImage->delete();
            }

            // Move new images to permanent storage
            foreach ($temporaryImages as $temporaryImage) {
                Storage::copy(
                    'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                    'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
                );

                // Associate new images with the menu
                MenuImage::create([
                    'menu_id' => $menu->id,
                    'image' => $temporaryImage->file,
                    'path' => $temporaryImage->folder . '/' . $temporaryImage->file
                ]);

                // Clean up temporary images
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
        }

        // Redirect to the menu listing page with a success message
        return redirect()->route('resort.menus')->with('success', 'Menu updated successfully.');
    }
}
