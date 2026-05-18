<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrelovedProduct;
use Illuminate\Http\Request;

class PrelovedController extends Controller
{
    public function index()
    {
        $prelovedProducts = PrelovedProduct::with('user')->latest()->get();
        
        // Jika tidak ada data, buat data dummy sementara
        if ($prelovedProducts->isEmpty()) {
            // Data dummy untuk ditampilkan
            $prelovedProducts = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Arduino Mega 2560',
                    'description' => 'Arduino Mega 2560 bekas skripsi, kondisi 90% baik',
                    'price' => 95000,
                    'condition' => 'good',
                    'verification_status' => 'pending',
                    'user' => (object)['name' => 'Budi Santoso', 'email' => 'budi@gmail.com']
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Raspberry Pi 3B+',
                    'description' => 'RPI 3B+ bekas 3 bulan, like new, lengkap case',
                    'price' => 450000,
                    'condition' => 'like-new',
                    'verification_status' => 'pending',
                    'user' => (object)['name' => 'Siti Rahayu', 'email' => 'siti@gmail.com']
                ],
                (object)[
                    'id' => 3,
                    'name' => 'ESP32-CAM with OV2640',
                    'description' => 'ESP32-CAM bekas project CCTV, masih berfungsi',
                    'price' => 55000,
                    'condition' => 'like-new',
                    'verification_status' => 'pending',
                    'user' => (object)['name' => 'Ahmad Fauzi', 'email' => 'ahmad@gmail.com']
                ],
            ]);
        }
        
        return view('admin.preloved.index', compact('prelovedProducts'));
    }
    
    public function approve($id)
    {
        $product = PrelovedProduct::find($id);
        if ($product) {
            $product->verification_status = 'approved';
            $product->save();
            return redirect()->back()->with('success', 'Product approved successfully!');
        }
        return redirect()->back()->with('error', 'Product not found');
    }
    
    public function reject(Request $request, $id)
    {
        $product = PrelovedProduct::find($id);
        if ($product) {
            $product->verification_status = 'rejected';
            $product->rejection_reason = $request->reason;
            $product->save();
            return redirect()->back()->with('success', 'Product rejected successfully!');
        }
        return redirect()->back()->with('error', 'Product not found');
    }
}