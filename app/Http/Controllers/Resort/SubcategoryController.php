<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

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
