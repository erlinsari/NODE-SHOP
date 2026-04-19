<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()->with('category')->take(8)->get();
        $newProducts = Product::active()->new()->with('category')->latest()->take(8)->get();
        $prelovedProducts = Product::active()->preloved()->with('category')->latest()->take(4)->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('home', compact('featuredProducts', 'newProducts', 'prelovedProducts', 'categories'));
    }
}
