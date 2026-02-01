<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">🔑 Karibu Tena</h1>
            <p class="auth-subtitle">Ingia kwenye akaunti yako kuendelea.</p>
        </div>

        <form wire:submit.prevent="login">
            <div class="form-group">
                <label class="form-label" for="phone">📱 Namba ya Simu</label>
                <input type="tel" id="phone" wire:model="phone" class="form-input" placeholder="0712345678" required>
                @error('phone')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">🔒 Password</label>
                <input type="password" id="password" wire:model="password" class="form-input" placeholder="••••••••"
                    required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" wire:model="remember">
                    <span>Nikumbuke</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <span wire:loading.remove>🚀 Ingia</span>
                <span wire:loading>⏳ Inapakia...</span>
            </button>
        </form>

        <div class="auth-footer">
            <p>Huna akaunti? <a href="{{ route('register') }}" wire:navigate>Jiandikishe hapa</a></p>
        </div>
    </div>
</div>