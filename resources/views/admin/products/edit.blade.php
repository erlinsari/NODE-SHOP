@extends('admin.layouts.admin')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>
    
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-6">
        @csrf @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Product Name</label>
            <input type="text" name="name" value="{{ $product->name ?? '' }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Category</label>
            <select name="category_id" class="w-full border rounded-lg px-3 py-2" required>
                <option value="">Select Category</option>
                @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}" {{ ($product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Price (Rp)</label>
                <input type="number" name="price" value="{{ $product->price ?? 0 }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Stock</label>
                <input type="number" name="stock" value="{{ $product->stock ?? 0 }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
        </div>
        
        <div class="form-group">
    <label for="condition">Kondisi Produk</label>
    <select name="condition" id="condition" class="form-control" required>
        <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>Baru</option>
        <option value="like_new" {{ $product->condition == 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
        <option value="good" {{ $product->condition == 'good' ? 'selected' : '' }}>Bagus</option>
        <option value="fair" {{ $product->condition == 'fair' ? 'selected' : '' }}>Cukup</option>
    </select>
</div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="5" class="w-full border rounded-lg px-3 py-2" required>{{ $product->description ?? '' }}</textarea>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Product Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
            @if($product->image ?? false)
            <img src="{{ Storage::url($product->image) }}" class="mt-2 h-20">
            @endif
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded-lg mr-2">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Product</button>
        </div>
    </form>
</div>
@endsection