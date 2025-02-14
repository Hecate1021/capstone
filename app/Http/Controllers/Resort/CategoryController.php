<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $resortId = $user->id; // The resort_id is the same as the user id

        // Fetch only categories belonging to the logged-in resort
        $categories = Category::with('subcategories')
            ->where('resort_id', $resortId)
            ->get();

        return view('resort.category.category', compact('categories'));
    }



    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create the category and assign the resort_id to the logged-in user
        Category::create([
            'name' => $request->name,
            'resort_id' => Auth::id(),  // Assign the authenticated user's ID as the resort_id
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Category added successfully!');
    }


    public function update(Request $request, Category $category)
    {


        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the category name
        $category->update([
            'name' => $request->input('name'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    // Delete Category
    public function destroy(Category $category)
    {
        // Check if category has subcategories
        if ($category->subcategories->count()) {
            return redirect()->back()->with('error', 'Cannot delete category with subcategories.');
        }

        // Delete the category
        $category->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
