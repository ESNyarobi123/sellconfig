@extends('layouts.app')

@section('title', 'Ingia')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">🔑 Karibu Tena</h1>
                <p class="auth-subtitle">Ingia kwenye akaunti yako kuendelea.</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="phone">📱 Namba ya Simu</label>
                    <input type="tel" id="phone" name="phone" class="form-input" placeholder="0712345678"
                        value="{{ old('phone') }}" required autocomplete="tel">
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">🔒 Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required
                        autocomplete="current-password">
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Nikumbuke</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <span>🚀</span>
                    Ingia
                </button>
            </form>

            <div class="auth-footer">
                <p>Huna akaunti? <a href="{{ route('register') }}">Jiandikishe hapa</a></p>
            </div>
        </div>
    </div>
@endsection