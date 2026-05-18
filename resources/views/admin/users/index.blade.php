@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Users Management</h1>
        <p class="text-gray-500 mt-1">Manage all registered customers</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Orders</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- DATA STATIS (TANPA DATABASE) -->
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Budi Santoso</span></div></td>
                    <td class="px-6 py-4">budi@gmail.com</td>
                    <td class="px-6 py-4">081298765432</td>
                    <td class="px-6 py-4">Jl. Teknik No. 10, Bandar Lampung</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">3 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Siti Rahayu</span></div></td>
                    <td class="px-6 py-4">siti@gmail.com</td>
                    <td class="px-6 py-4">081234567891</td>
                    <td class="px-6 py-4">Jl. Mawar Indah No. 5, Surabaya</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">2 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Ahmad Fauzi</span></div></td>
                    <td class="px-6 py-4">ahmad@gmail.com</td>
                    <td class="px-6 py-4">081234567892</td>
                    <td class="px-6 py-4">Jl. Merdeka No. 20, Bandung</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">5 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Dewi Anggraeni</span></div></td>
                    <td class="px-6 py-4">dewi@gmail.com</td>
                    <td class="px-6 py-4">081234567893</td>
                    <td class="px-6 py-4">Jl. Diponegoro No. 8, Yogyakarta</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">1 order</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Rizki Ramadhan</span></div></td>
                    <td class="px-6 py-4">rizki@gmail.com</td>
                    <td class="px-6 py-4">081234567894</td>
                    <td class="px-6 py-4">Jl. Sudirman No. 15, Semarang</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">0 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Putri Lestari</span></div></td>
                    <td class="px-6 py-4">putri@gmail.com</td>
                    <td class="px-6 py-4">081234567895</td>
                    <td class="px-6 py-4">Jl. Kenanga No. 3, Malang</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">2 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Hendra Wijaya</span></div></td>
                    <td class="px-6 py-4">hendra@gmail.com</td>
                    <td class="px-6 py-4">081234567896</td>
                    <td class="px-6 py-4">Jl. Pahlawan No. 12, Medan</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">4 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Rina Kusumawati</span></div></td>
                    <td class="px-6 py-4">rina@gmail.com</td>
                    <td class="px-6 py-4">081234567897</td>
                    <td class="px-6 py-4">Jl. Gatot Subroto No. 7, Makassar</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">1 order</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Andi Saputra</span></div></td>
                    <td class="px-6 py-4">andi@gmail.com</td>
                    <td class="px-6 py-4">081234567898</td>
                    <td class="px-6 py-4">Jl. Thamrin No. 25, Palembang</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">0 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-red-600"></i></div><span class="font-medium">Maya Sari</span></div></td>
                    <td class="px-6 py-4">maya@gmail.com</td>
                    <td class="px-6 py-4">081234567899</td>
                    <td class="px-6 py-4">Jl. Asia Afrika No. 30, Denpasar</td>
                    <td class="px-6 py-4"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">2 orders</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection