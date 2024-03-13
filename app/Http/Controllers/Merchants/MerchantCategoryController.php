<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\QueryException;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class MerchantCategoryController extends Controller
{
    public function viewSubCategory()
    {
        try {
            $categories = Category::all();
            $id = Auth::user()->id;
            $subcategories = SubCategory::where('merchant_id', $id)->get();
            return view('merchant.subCategories', compact('categories','subcategories'));
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
}
