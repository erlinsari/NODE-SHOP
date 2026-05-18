@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Preloved Products Verification</h1>
        <p class="text-gray-500 mt-1">Verify products submitted by customers</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Seller</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Condition</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prelovedProducts as $product)
                <tr class="border-t hover:bg-gray-50" id="row-{{ $product->id }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-red-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $product->user->name ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-500">{{ $product->user->email ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($product->condition == 'like-new') bg-green-100 text-green-800
                            @elseif($product->condition == 'good') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($product->condition) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full status-badge-{{ $product->id }}
                            @if($product->verification_status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($product->verification_status == 'approved') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($product->verification_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->verification_status == 'pending')
                        <div class="flex gap-2">
                            <button onclick="approveProduct({{ $product->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                Approve
                            </button>
                            <button onclick="rejectProduct({{ $product->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                Reject
                            </button>
                        </div>
                        @else
                        <span class="text-gray-400">{{ $product->verification_status == 'approved' ? 'Verified' : 'Rejected' }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No preloved products found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function approveProduct(id) {
        if(confirm('Approve this product?')) {
            fetch(`/admin/preloved/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      location.reload();
                  }
              });
        }
    }

    function rejectProduct(id) {
        let reason = prompt('Reason for rejection:');
        if(reason) {
            fetch(`/admin/preloved/${id}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({reason: reason})
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      location.reload();
                  }
              });
        }
    }
</script>
@endsection