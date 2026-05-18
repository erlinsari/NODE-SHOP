@extends('admin.layouts.admin')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">System Settings</h1>
    
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Store Name</label>
            <input type="text" name="store_name" value="{{ $settings['store_name'] }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Store Email</label>
            <input type="email" name="store_email" value="{{ $settings['store_email'] }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Store Logo</label>
            <input type="file" name="logo" accept="image/*" class="w-full border rounded-lg px-3 py-2">
            @if($settings['logo'])
            <img src="{{ Storage::url($settings['logo']) }}" class="mt-2 h-12">
            @endif
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Shipping Cost</label>
            <input type="number" name="shipping_cost" value="{{ $settings['shipping_cost'] }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Social Media</label>
            <input type="url" name="instagram" placeholder="Instagram URL" value="{{ $settings['instagram'] }}" class="w-full border rounded-lg px-3 py-2 mb-2">
            <input type="url" name="github" placeholder="GitHub URL" value="{{ $settings['github'] }}" class="w-full border rounded-lg px-3 py-2 mb-2">
            <input type="url" name="linkedin" placeholder="LinkedIn URL" value="{{ $settings['linkedin'] }}" class="w-full border rounded-lg px-3 py-2 mb-2">
            <input type="url" name="youtube" placeholder="YouTube URL" value="{{ $settings['youtube'] }}" class="w-full border rounded-lg px-3 py-2">
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Settings</button>
        </div>
    </form>
</div>
@endsection
@extends('admin.layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold">Settings</h1>
    <p class="text-gray-600 mt-2">System settings page - Coming soon</p>
</div>
@endsection