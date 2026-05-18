@extends('admin.layouts.admin')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Preloved Product Details</h1>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                @if($preloved->image ?? false)
                <img src="{{ Storage::url($preloved->image) }}" class="w-full rounded-lg">
                @endif
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2">{{ $preloved->name ?? '' }}</h2>
                <p class="text-2xl text-blue-600 font-bold mb-4">Rp {{ number_format($preloved->price ?? 0, 0, ',', '.') }}</p>
                <p class="text-gray-600 mb-4">{{ $preloved->description ?? '' }}</p>
                <p><strong>Condition:</strong> {{ $preloved->condition ?? '' }}</p>
                <p><strong>Seller:</strong> {{ $preloved->user->name ?? 'Unknown' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($preloved->verification_status ?? 'pending') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection