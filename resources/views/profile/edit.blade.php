@extends('layouts.app')
@section('title', 'My Profile — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container" style="max-width:900px;">
        {{-- Header --}}
        <div class="reveal" style="margin-bottom:2rem;">
            <h1 class="font-black uppercase" style="font-size:clamp(2.5rem, 6vw, 4.5rem); margin-bottom:0.5rem;">
                My <span class="text-primary">Profile</span>
            </h1>
            <p class="font-mono text-muted">ACCOUNT SETTINGS / {{ strtoupper(auth()->user()->email) }}</p>
        </div>

        {{-- Profile Info Card --}}
        <div class="card card-2x reveal" style="margin-bottom:2rem;">
            <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between;">
                <h2 class="font-black uppercase" style="font-size:0.95rem; display:flex; align-items:center; gap:0.75rem;">
                    <i class="fas fa-user text-primary"></i> Profile Information
                </h2>
                <span class="badge badge-outline font-mono">PERSONAL</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;" class="profile-form-grid">
                        <div>
                            <label class="form-label">Full Name *</label>
                            <div class="form-input-icon">
                                <i class="fas fa-user icon"></i>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input" placeholder="Your full name">
                            </div>
                            @error('name') <p style="color:#FF0000; font-size:0.75rem; font-family:'JetBrains Mono'; margin-top:0.25rem;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Email Address *</label>
                            <div class="form-input-icon">
                                <i class="fas fa-envelope icon"></i>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input" placeholder="you@example.com">
                            </div>
                            @error('email') <p style="color:#FF0000; font-size:0.75rem; font-family:'JetBrains Mono'; margin-top:0.25rem;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;" class="profile-form-grid">
                        <div>
                            <label class="form-label">Phone</label>
                            <div class="form-input-icon">
                                <i class="fas fa-phone icon"></i>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" class="form-input" placeholder="Your city">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;" class="profile-form-grid">
                        <div>
                            <label class="form-label">Province</label>
                            <input type="text" name="province" value="{{ old('province', $user->province) }}" class="form-input" placeholder="Province">
                        </div>
                        <div>
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="form-input" placeholder="12345">
                        </div>
                    </div>

                    <div style="margin-bottom:1.5rem;">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="3" class="form-input" style="resize:vertical;" placeholder="Full street address">{{ old('address', $user->address) }}</textarea>
                    </div>

                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success" style="margin-bottom:1rem;">
                            <i class="fas fa-check-circle" style="margin-right:0.5rem;"></i> Profile updated successfully!
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save" style="margin-right:0.5rem;"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>

        {{-- Change Password Card --}}
        <div class="card card-2x reveal" style="margin-bottom:2rem;">
            <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between;">
                <h2 class="font-black uppercase" style="font-size:0.95rem; display:flex; align-items:center; gap:0.75rem;">
                    <i class="fas fa-lock text-primary"></i> Update Password
                </h2>
                <span class="badge badge-outline font-mono">SECURITY</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div style="display:flex; flex-direction:column; gap:1rem; margin-bottom:1.5rem;">
                        <div>
                            <label class="form-label">Current Password *</label>
                            <div class="form-input-icon">
                                <i class="fas fa-lock icon"></i>
                                <input type="password" name="current_password" required class="form-input" placeholder="••••••••">
                            </div>
                            @error('current_password', 'updatePassword') <p style="color:#FF0000; font-size:0.75rem; font-family:'JetBrains Mono'; margin-top:0.25rem;">{{ $message }}</p> @enderror
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="profile-form-grid">
                            <div>
                                <label class="form-label">New Password *</label>
                                <div class="form-input-icon">
                                    <i class="fas fa-key icon"></i>
                                    <input type="password" name="password" required class="form-input" placeholder="••••••••">
                                </div>
                                @error('password', 'updatePassword') <p style="color:#FF0000; font-size:0.75rem; font-family:'JetBrains Mono'; margin-top:0.25rem;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Confirm New Password *</label>
                                <div class="form-input-icon">
                                    <i class="fas fa-key icon"></i>
                                    <input type="password" name="password_confirmation" required class="form-input" placeholder="••••••••">
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(session('status') === 'password-updated')
                        <div class="alert alert-success" style="margin-bottom:1rem;">
                            <i class="fas fa-check-circle" style="margin-right:0.5rem;"></i> Password updated successfully!
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key" style="margin-right:0.5rem;"></i> Update Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Account Stats --}}
        <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem; margin-bottom:2rem;">
            <div class="card card-2x">
                <div class="card-body" style="text-align:center;">
                    <i class="fas fa-shopping-bag text-primary" style="font-size:1.5rem; margin-bottom:0.75rem;"></i>
                    <p class="font-black" style="font-size:1.5rem;">{{ auth()->user()->orders()->count() }}</p>
                    <p class="font-mono text-muted" style="font-size:0.75rem;">TOTAL ORDERS</p>
                </div>
            </div>
            <div class="card card-2x">
                <div class="card-body" style="text-align:center;">
                    <i class="fas fa-shopping-cart text-primary" style="font-size:1.5rem; margin-bottom:0.75rem;"></i>
                    <p class="font-black" style="font-size:1.5rem;">{{ auth()->user()->carts()->count() }}</p>
                    <p class="font-mono text-muted" style="font-size:0.75rem;">CART ITEMS</p>
                </div>
            </div>
            <div class="card card-2x">
                <div class="card-body" style="text-align:center;">
                    <i class="fas fa-calendar text-primary" style="font-size:1.5rem; margin-bottom:0.75rem;"></i>
                    <p class="font-black" style="font-size:0.9rem;">{{ auth()->user()->created_at->format('d M Y') }}</p>
                    <p class="font-mono text-muted" style="font-size:0.75rem;">MEMBER SINCE</p>
                </div>
            </div>
            <div class="card card-2x">
                <div class="card-body" style="text-align:center;">
                    <i class="fas fa-shield-alt text-primary" style="font-size:1.5rem; margin-bottom:0.75rem;"></i>
                    <p class="font-black" style="font-size:0.9rem;">{{ ucfirst(auth()->user()->role) }}</p>
                    <p class="font-mono text-muted" style="font-size:0.75rem;">ACCOUNT ROLE</p>
                </div>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="card reveal" style="border:2px solid rgba(255,0,0,0.3);">
            <div class="card-header" style="border-bottom:2px solid rgba(255,0,0,0.2);">
                <h2 class="font-black uppercase" style="font-size:0.95rem; color:#FF0000; display:flex; align-items:center; gap:0.75rem;">
                    <i class="fas fa-exclamation-triangle"></i> Danger Zone
                </h2>
            </div>
            <div class="card-body" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
                <div>
                    <p class="font-bold" style="font-size:0.9rem; margin-bottom:0.25rem;">Delete Account</p>
                    <p class="font-mono text-muted" style="font-size:0.8rem;">Permanently delete your account and all related data</p>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <input type="password" name="password" placeholder="Confirm password" required class="form-input" style="width:auto; display:inline-block; margin-right:0.5rem; font-size:0.8rem;">
                    <button type="submit" class="btn" style="background:transparent; border:2px solid #FF0000; color:#FF0000; padding:0.5rem 1rem; font-size:0.8rem;">
                        <i class="fas fa-trash-alt" style="margin-right:0.5rem;"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @media(max-width: 768px) {
        .profile-form-grid { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection
