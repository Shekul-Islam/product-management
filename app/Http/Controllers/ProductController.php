<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Add this line

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::with('categories')->latest()->get();

        return response()->json([
            'products' => $products,
        ]);
    }

    // Store a newly created product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')
            ? $request->file('image')->store('images', 'public')
            : null;

        // Create product
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        // Sync categories
        $product->categories()->sync($request->categories);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        // Delete product image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image); // <-- Use Storage here
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}
