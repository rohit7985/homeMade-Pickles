<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;


class SubCategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            $subcategories = SubCategory::all();

            return view('admin.subCategories', compact('categories','subcategories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $request->validate([
                'categoryId' => 'required|exists:categories,id',
                'subcategory' => 'required|string|max:255',
            ]);

            SubCategory::create([
                'category_id' => $request->input('categoryId'),
                'sub_category' => $request->input('subcategory'),
                'merchant_id' => $id,
            ]);
            return redirect()->back()->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function deleteSubCategory($id)
    {
        try {
            $category = SubCategory::findOrFail($id);
            $category->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } catch (QueryException $e) {
            dd($e);
            return response()->json(['success' => false, 'message' => 'Error deleting category.']);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.']);
        }
    }

    public function updateSubCategory(Request $request)
    {
        try {
            $request->validate([
                'subcategoryName' => 'required|string|max:255',
                'categoryId' => 'required|exists:categories,id',
            ]);
            $sub_category = SubCategory::findOrFail($request->input('subcategoryId'));
            $sub_category->update([
                'sub_category' => $request->input('subcategoryName'),
                'category_id' => $request->input('categoryId'),
            ]);
            return redirect()->back()->with('success', 'SubCategory updated successfully');
        } catch (\Exception $e) {
            // Other exceptions
            dd($e);
            return redirect()->back()->with('error', 'An error occurred while updating the SubCategory.');
        }
    }
}
