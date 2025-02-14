<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('resort_id', Auth::id()), // Ensure category belongs to the logged-in user
            ],
        ]);

        // Create a new subcategory with resort_id set to the authenticated user's ID
        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'resort_id' => Auth::id(),  // Assign resort_id to the authenticated user's ID
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Subcategory created successfully!');
    }


    // Update Subcategory
    public function update(Request $request, Category $category, Subcategory $subcategory)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the subcategory name
        $subcategory->update([
            'name' => $request->input('name'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Subcategory updated successfully.');
    }

    // Delete Subcategory
    public function destroy(Category $category, Subcategory $subcategory)
    {
        // Delete the subcategory
        $subcategory->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Subcategory deleted successfully.');
    }
}
