<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'icon' => 'nullable|max:100',
        ]);
        
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'fa-tag',
        ]);
        
        return redirect()->back()->with('success', 'Category "' . $request->name . '" added successfully!');
    }
    
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            if ($category->products()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete category with products!');
            }
            $category->delete();
            return redirect()->back()->with('success', 'Category "' . $category->name . '" deleted successfully!');
        }
        return redirect()->back()->with('error', 'Category not found');
    }
}