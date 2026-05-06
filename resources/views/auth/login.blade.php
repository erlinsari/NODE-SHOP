<x-guest-layout>
    <h2 style="font-weight:900; font-size:1.5rem; text-transform:uppercase; margin-bottom:0.5rem; text-align:center;">
        Welcome <span style="color:#FF0000;">Back</span>
    </h2>
    <p class="font-mono" style="font-size:0.8rem; color:var(--muted-fg); text-align:center; margin-bottom:1.5rem;">
        Sign in to your NODE SHOP account
    </p>

    @if(session('status'))
        <div style="padding:0.75rem 1rem; background:rgba(22,163,74,0.1); border-left:3px solid #16a34a; color:#16a34a; font-size:0.8rem; margin-bottom:1rem; border-radius:2px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom:1rem;">
            <label class="form-label">Email *</label>
            <div class="form-input-icon">
                <i class="fas fa-envelope icon"></i>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input" placeholder="you@example.com">
            </div>
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:1rem;">
            <label class="form-label">Password *</label>
            <div class="form-input-icon">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" required autocomplete="current-password" class="form-input" placeholder="••••••••">
            </div>
            @error('password') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                <input type="checkbox" name="remember" style="accent-color:#FF0000;">
                <span class="font-mono" style="font-size:0.8rem;">Remember me</span>
            </label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-mono" style="font-size:0.75rem; color:#FF0000;">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-sign-in-alt" style="margin-right:0.5rem;"></i> Sign In
        </button>
    </form>

    <div style="position:relative; margin:1.5rem 0;">
        <div style="height:1px; background:var(--border);"></div>
        <span class="font-mono" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:var(--card); padding:0 0.75rem; font-size:0.7rem; color:var(--muted-fg);">OR</span>
    </div>

    <p class="font-mono" style="text-align:center; font-size:0.8rem; color:var(--muted-fg);">
        Don't have an account?
        <a href="{{ route('register') }}" style="color:#FF0000; font-weight:600;">Create Account</a>
    </p>
</x-guest-layout>
