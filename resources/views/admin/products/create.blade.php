@extends('admin.layouts.admin')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Add Product</h1>
        <p class="text-gray-500 mt-1">Create a new product for your store</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input type="text" name="name" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-500" required>
            </div>
            
           <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Category *
    </label>

    <select name="category_id"
        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-500"
        required>

        <option value="">Select Category</option>

        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->icon }} {{ $category->name }}
            </option>
        @endforeach

    </select>
</div>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price (Rp) *</label>
                <input type="number" name="price" class="w-full border rounded-xl px-4 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                <input type="number" name="stock" class="w-full border rounded-xl px-4 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                <input type="text" name="brand" class="w-full border rounded-xl px-4 py-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                <select name="condition" class="w-full border rounded-xl px-4 py-2">
                    <option value="new">New</option>
                    <option value="like-new">Like New</option>
                    <option value="good">Good</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="5" class="w-full border rounded-xl px-4 py-2" required></textarea>
            </div>
        
            
            <div class="flex items-center">
                <input type="checkbox" name="is_active" class="mr-2" checked> Active Product
            </div>
        </div>
        
        <div class="flex justify-end mt-8 pt-6 border-t">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border rounded-xl mr-3 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="btn-primary" style="background:#dc2626; color:white; padding:0.5rem 1.5rem; border-radius:0.75rem;">
                <i class="fas fa-save mr-2"></i> Save Product
            </button>
        </div>
    </form>
</div>
@endsection