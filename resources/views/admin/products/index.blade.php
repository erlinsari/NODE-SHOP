@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <div><h1 class="text-2xl font-bold">Products</h1><p class="text-gray-500 mt-1">Manage your product catalog</p></div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary" style="background:#dc2626; color:white; padding:0.5rem 1rem; border-radius:0.75rem; text-decoration:none;">
            <i class="fas fa-plus mr-2"></i>Add Product
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4"><div><p class="font-medium"><div class="flex items-center gap-2">
    <span class="text-xl">
        {{ $product->category->icon ?? '📦' }}
    </span>

    <div>
        <p class="font-medium">{{ $product->name }}</p>
        <p class="text-sm text-gray-500">
            {{ $product->category->name ?? '-' }}
        </p>
    </div>
</div></p><p class="text-sm text-gray-500">{{ $product->category->name ?? '-' }}</p></div></td>
                    <td class="px-6 py-4 font-semibold text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $product->stock }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-6 py-4"><a href="{{ route('admin.products.edit', $product) }}" class="text-red-600 hover:text-red-700 mr-3">Edit</a><form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete product?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-700">Delete</button></form></td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No products found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection