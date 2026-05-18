<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'store_name' => Setting::get('store_name', 'NODESHOP'),
            'store_email' => Setting::get('store_email', 'admin@nodeshop.com'),
            'store_phone' => Setting::get('store_phone', ''),
            'store_address' => Setting::get('store_address', ''),
            'shipping_cost' => Setting::get('shipping_cost', 10000),
            'logo' => Setting::get('logo', ''),
            'payment_gateway_key' => Setting::get('payment_gateway_key', ''),
            'instagram' => Setting::get('instagram', ''),
            'github' => Setting::get('github', ''),
            'linkedin' => Setting::get('linkedin', ''),
            'youtube' => Setting::get('youtube', ''),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|max:255',
            'store_email' => 'required|email',
            'store_phone' => 'nullable',
            'store_address' => 'nullable',
            'shipping_cost' => 'required|numeric',
            'payment_gateway_key' => 'nullable',
            'instagram' => 'nullable|url',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $logoPath);
        }
        
        foreach ($validated as $key => $value) {
            if ($key !== 'logo') {
                Setting::set($key, $value);
            }
        }
        
        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}