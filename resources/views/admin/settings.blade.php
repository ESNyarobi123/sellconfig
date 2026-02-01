@extends('layouts.admin')

@section('title', 'Settings')
@section('header', '⚙️ Settings')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <!-- Payment Settings -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">💳 Payment Settings (HarakaPay)</h3>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-group">
                    <label class="form-label" for="harakapay_api_key">API Key</label>
                    <input type="text" id="harakapay_api_key" name="harakapay_api_key" class="form-input"
                        value="{{ $settings['harakapay_api_key'] }}" placeholder="hpk_xxxxx...">
                    <small class="text-muted">HarakaPay API Key yako ya malipo</small>
                </div>

                <div class="admin-form-group">
                    <label class="form-label">Payment Status</label>
                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                        <label class="toggle-switch">
                            <input type="checkbox" name="payment_enabled" value="1" {{ $settings['payment_enabled'] ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="text-muted">
                            {{ $settings['payment_enabled'] ? '✅ Malipo yamewashwa' : '❌ Malipo yamezimwa (Test Mode)' }}
                        </span>
                    </div>
                    <small class="text-muted mt-2" style="display: block;">
                        Ukizima hii, users watapata configs bila kulipa (kwa majaribio tu).
                    </small>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">📱 Contact Settings</h3>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-group">
                    <label class="form-label" for="whatsapp_number">WhatsApp Number</label>
                    <input type="tel" id="whatsapp_number" name="whatsapp_number" class="form-input"
                        value="{{ $settings['whatsapp_number'] }}" placeholder="255712345678">
                    <small class="text-muted">Namba ya WhatsApp kwa support (na country code, mfano: 255712345678)</small>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="support_message">Support Message</label>
                    <textarea id="support_message" name="support_message" class="form-input form-textarea" rows="3"
                        placeholder="Ujumbe wa kuwakaribisha wateja...">{{ $settings['support_message'] }}</textarea>
                    <small class="text-muted">Ujumbe utaoonyesha kwenye homepage</small>
                </div>
            </div>
        </div>

        <!-- App Links & Socials -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">🔗 App Links & Socials</h3>
            </div>
            <div class="admin-card-body">
                <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div class="admin-form-group" style="flex: 1; min-width: 300px;">
                        <label class="form-label" for="app_halotel_link">🟢 Halotel App Link</label>
                        <input type="url" id="app_halotel_link" name="app_halotel_link" class="form-input"
                            value="{{ $settings['app_halotel_link'] }}" placeholder="https://...">
                    </div>

                    <div class="admin-form-group" style="flex: 1; min-width: 300px;">
                        <label class="form-label" for="app_airtel_link">🔴 Airtel App Link</label>
                        <input type="url" id="app_airtel_link" name="app_airtel_link" class="form-input"
                            value="{{ $settings['app_airtel_link'] }}" placeholder="https://...">
                    </div>
                </div>

                <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div class="admin-form-group" style="flex: 1; min-width: 300px;">
                        <label class="form-label" for="whatsapp_link">💬 WhatsApp Group/Chat Link</label>
                        <input type="url" id="whatsapp_link" name="whatsapp_link" class="form-input"
                            value="{{ $settings['whatsapp_link'] }}" placeholder="https://wa.me/...">
                    </div>

                    <div class="admin-form-group" style="flex: 1; min-width: 300px;">
                        <label class="form-label" for="youtube_link">📺 YouTube Channel Link</label>
                        <input type="url" id="youtube_link" name="youtube_link" class="form-input"
                            value="{{ $settings['youtube_link'] }}" placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Site Settings -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">🌐 Site Settings</h3>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-group">
                    <label class="form-label" for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name" class="form-input"
                        value="{{ $settings['site_name'] }}" placeholder="SellConfig">
                </div>
            </div>
        </div>

        <div style="display: flex; gap: var(--spacing-md);">
            <button type="submit" class="btn btn-primary" style="width: auto;">
                💾 Save Settings
            </button>
        </div>
    </form>

    <!-- Danger Zone -->
    <div class="admin-card" style="margin-top: var(--spacing-xl); border-color: var(--error);">
        <div class="admin-card-header" style="border-color: rgba(239, 68, 68, 0.3);">
            <h3 class="admin-card-title" style="color: var(--error);">⚠️ Danger Zone</h3>
        </div>
        <div class="admin-card-body">
            <p class="text-muted mb-3">Actions here are irreversible. Be careful!</p>
            <div class="action-buttons">
                <a href="{{ route('admin.configs.index') }}" class="btn btn-danger" style="width: auto;">
                    🗑️ Manage All Configs
                </a>
            </div>
        </div>
    </div>
@endsection