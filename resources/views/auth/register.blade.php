@extends('layouts.app')

@section('title', 'Jiandikishe')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">✨ Jiandikishe</h1>
                <p class="auth-subtitle">Tengeneza akaunti yako ya bure.</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">👤 Jina Lako</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="John Doe"
                        value="{{ old('name') }}" required autocomplete="name">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">📱 Namba ya Simu</label>
                    <input type="tel" id="phone" name="phone" class="form-input" placeholder="0712345678"
                        value="{{ old('phone') }}" required autocomplete="tel" maxlength="10">
                    <small class="text-muted">Tumia namba ya Tanzania (mfano: 0712345678)</small>
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">🔒 Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required
                        autocomplete="new-password" minlength="6">
                    <small class="text-muted">Angalau herungu 6</small>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">🔒 Thibitisha Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                        placeholder="••••••••" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">
                    <span>🚀</span>
                    Jiandikishe
                </button>
            </form>

            <div class="auth-footer">
                <p>Tayari una akaunti? <a href="{{ route('login') }}">Ingia hapa</a></p>
            </div>
        </div>
    </div>
@endsection