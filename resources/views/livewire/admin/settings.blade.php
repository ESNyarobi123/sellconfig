@section('title', 'Settings')
@section('header', '⚙️ General Settings')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="admin-card-body">
        <form wire:submit="save">

            <!-- General Settings -->
            <div class="settings-section" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">📝 General Info
                </h3>

                <div class="form-group">
                    <label class="form-label">Site Name</label>
                    <input type="text" wire:model="site_name" class="form-input">
                    @error('site_name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">WhatsApp Number (Support)</label>
                        <input type="text" wire:model="whatsapp_number" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Support Message</label>
                    <textarea wire:model="support_message" class="form-input" rows="3"></textarea>
                </div>
            </div>

            <!-- App Downloads -->
            <div class="settings-section" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">📲 App Downloads
                </h3>

                <div class="form-group">
                    <label class="form-label">🟢 Halotel App Link</label>
                    <input type="text" wire:model="app_halotel_link" class="form-input" placeholder="https://...">
                    @error('app_halotel_link') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">🔴 Airtel App Link</label>
                    <input type="text" wire:model="app_airtel_link" class="form-input" placeholder="https://...">
                    @error('app_airtel_link') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Social Links -->
            <div class="settings-section" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">🌐 Social Media
                </h3>

                <div class="form-group">
                    <label class="form-label">WhatsApp Channel/Link</label>
                    <input type="url" wire:model="social_whatsapp" class="form-input">
                    @error('social_whatsapp') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">YouTube Channel</label>
                    <input type="url" wire:model="social_youtube" class="form-input">
                    @error('social_youtube') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Payment Settings -->
            <div class="settings-section" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">💳 Payment
                    (HarakaPay)</h3>

                <div class="form-group">
                    <label class="form-label">API Key</label>
                    <input type="password" wire:model="harakapay_api_key" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" wire:model="payment_enabled">
                        <span>Enable Payments</span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span wire:loading.remove>Save Settings</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>