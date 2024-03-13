<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\QueryException;


class CategoryController extends Controller
{
    public function index()
    {
        try {
            // Fetch all categories with their subcategories
            $categories = Category::all();
            return view('admin.categories', compact('categories'));
        } catch (QueryException $e) {
            // Handle database query exceptions
            return redirect()->back()->with('error', 'Error fetching categories: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Validation logic here
            $request->validate([
                'categoryName' => 'required|string|max:255',
            ]);
            $category = new Category();
            $category->category = $request->input('categoryName');
            $category->save();
            return redirect()->back()->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function deleteCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
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

    public function updateCategory(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|max:255',
            'categoryId' => 'required|exists:categories,id',
        ]);

        $category = Category::findOrFail($request->input('categoryId'));
        $category->update([
            'category' => $request->input('categoryName'),
            // Add other fields as needed
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }
}
