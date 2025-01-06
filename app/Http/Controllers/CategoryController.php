<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        return response()->json([
            'categories' => Category::latest()->get(),
        ]);
    }

    // Store a newly created category in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create($request->all());

        return response()->json([
            'message' => 'Category created successfully.',
            'category' => $category,
        ], 201);
    }

    // Remove the specified category from storage
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
