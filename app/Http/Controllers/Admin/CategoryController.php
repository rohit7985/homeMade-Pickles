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
                'parentCategory' => 'nullable', // Validate that the selected parent category exists
                'categoryLevel' => 'required|integer',
            ]);

            // Create the category
            $category = new Category();
            $category->name = $request->input('categoryName');

            if ($request->has('parentCategory')) {
                $parentCategory = Category::find($request->input('parentCategory'));

                if ($parentCategory) {
                    $category->parent_id = $parentCategory->id;
                    $category->level = $parentCategory->level + 1;
                }
            } else {
                $category->level = $request->input('categoryLevel');
            }
            $category->save();

            return redirect()->back()->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
