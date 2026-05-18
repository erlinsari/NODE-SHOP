@extends('admin.layouts.admin')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Categories</h1>
        <p class="text-gray-500 mt-1">Manage product categories</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <!-- Add Category Form -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Add New Category</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="name" placeholder="Category Name" class="flex-1 border rounded-xl px-4 py-2" required>
            <select name="icon" class="flex-1 border rounded-xl px-4 py-2" required>
    <option value="">Select Icon</option>

    <option value="🔧">🔧 Mikrokontroler</option>
    <option value="📡">📡 Sensor & Aktuator</option>
    <option value="📟">📟 Module & Shield</option>
    <option value="📦">📦 Starter Kit</option>
    <option value="🛠️">🛠️ Tools & Aksesoris</option>
    <option value="♻️">♻️ IoT Preloved</option>

    <option value="💡">💡 Elektronik</option>
    <option value="🔋">🔋 Power & Battery</option>
    <option value="📱">📱 Smart Device</option>
    <option value="🖥️">🖥️ Komputer</option>
    <option value="📷">📷 Kamera</option>
    <option value="🎮">🎮 Gaming</option>
</select>

            <button type="submit" class="btn-primary" style="background:#dc2626; color:white; padding:0.5rem 1.5rem; border-radius:0.75rem;">
                <i class="fas fa-plus mr-2"></i>Add Category
            </button>
        </form>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Icon</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr class="border-t hover:bg-gray-50">
                   <td class="px-6 py-4 font-medium flex items-center gap-2">
    <span class="text-2xl">{{ $category->icon }}</span>
    <span>{{ $category->name }}</span>
</td>

                   <td class="px-6 py-4 text-2xl">
    {{ $category->icon }}
</td>

                    <td class="px-6 py-4">{{ $category->products_count }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete category &quot;{{ $category->name }}&quot;? This will not delete products.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No categories yet. Add your first category above.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection