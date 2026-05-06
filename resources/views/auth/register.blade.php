<x-guest-layout>
    <h2 style="font-weight:900; font-size:1.5rem; text-transform:uppercase; margin-bottom:0.5rem; text-align:center;">
        Create <span style="color:#FF0000;">Account</span>
    </h2>
    <p class="font-mono" style="font-size:0.8rem; color:var(--muted-fg); text-align:center; margin-bottom:1.5rem;">
        Join NODE SHOP for premium IoT hardware
    </p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom:1rem;">
            <label class="form-label">Full Name *</label>
            <div class="form-input-icon">
                <i class="fas fa-user icon"></i>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input" placeholder="John Doe">
            </div>
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:1rem;">
            <label class="form-label">Email *</label>
            <div class="form-input-icon">
                <i class="fas fa-envelope icon"></i>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-input" placeholder="you@example.com">
            </div>
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">
            <div>
                <label class="form-label">Password *</label>
                <div class="form-input-icon">
                    <i class="fas fa-lock icon"></i>
                    <input type="password" name="password" required autocomplete="new-password" class="form-input" placeholder="••••••••">
                </div>
                @error('password') <p class="error-text">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Confirm *</label>
                <div class="form-input-icon">
                    <i class="fas fa-lock icon"></i>
                    <input type="password" name="password_confirmation" required autocomplete="new-password" class="form-input" placeholder="••••••••">
                </div>
                @error('password_confirmation') <p class="error-text">{{ $message }}</p> @enderror
            </div>
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-user-plus" style="margin-right:0.5rem;"></i> Create Account
        </button>
    </form>

    <div style="position:relative; margin:1.5rem 0;">
        <div style="height:1px; background:var(--border);"></div>
        <span class="font-mono" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:var(--card); padding:0 0.75rem; font-size:0.7rem; color:var(--muted-fg);">OR</span>
    </div>

    <p class="font-mono" style="text-align:center; font-size:0.8rem; color:var(--muted-fg);">
        Already have an account?
        <a href="{{ route('login') }}" style="color:#FF0000; font-weight:600;">Sign In</a>
    </p>
</x-guest-layout>
