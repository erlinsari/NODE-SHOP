<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'position' => 'required|in:home,sidebar,promo',
            'link' => 'nullable|url',
        ]);
        
        $imagePath = $request->file('image')->store('banners', 'public');
        
        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'link' => $request->link,
            'position' => $request->position,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);
        
        return redirect()->route('admin.banners.index')->with('success', 'Banner created.');
    }
    
    public function toggleStatus(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        return response()->json(['success' => true]);
    }
    
    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted.');
    }
}