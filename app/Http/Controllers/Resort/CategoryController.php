<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with('subcategories')->get();

        return view('resort.category.category', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new category
        Category::create([
            'name' => $request->name,
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
