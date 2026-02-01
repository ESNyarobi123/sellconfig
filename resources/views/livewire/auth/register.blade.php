<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">✨ Jiandikishe</h1>
            <p class="auth-subtitle">Tengeneza akaunti yako ya bure.</p>
        </div>

        <form wire:submit.prevent="register">
            <div class="form-group">
                <label class="form-label" for="name">👤 Jina Lako</label>
                <input type="text" id="name" wire:model="name" class="form-input" placeholder="John Doe" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">📱 Namba ya Simu</label>
                <input type="tel" id="phone" wire:model="phone" class="form-input" placeholder="0712345678" required
                    maxlength="10">
                <small class="text-muted">Tumia namba ya Tanzania (mfano: 0712345678)</small>
                @error('phone')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">🔒 Password</label>
                <input type="password" id="password" wire:model="password" class="form-input" placeholder="••••••••"
                    required minlength="6">
                <small class="text-muted">Angalau herufi 6</small>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">🔒 Thibitisha Password</label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-input"
                    placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <span wire:loading.remove>🚀 Jiandikishe</span>
                <span wire:loading>⏳ Inasajili...</span>
            </button>
        </form>

        <div class="auth-footer">
            <p>Tayari una akaunti? <a href="{{ route('login') }}" wire:navigate>Ingia hapa</a></p>
        </div>
    </div>
</div>