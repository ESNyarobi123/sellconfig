@section('title', 'Add Configs')
@section('header', '📤 Add New Configs')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="admin-card-body">
        <form wire:submit="save">
            <div class="form-group">
                <label class="form-label">Select Plan</label>
                <select wire:model="plan_id" class="form-select" required>
                    <option value="">-- Choose Plan --</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->name }} (Price: {{ $plan->price }})</option>
                    @endforeach
                </select>
                @error('plan_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Upload Type</label>
                <div style="display: flex; gap: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" wire:model.live="upload_type" value="bulk">
                        <span>📦 Bulk Upload (Many)</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" wire:model.live="upload_type" value="single">
                        <span>📝 Single Config (One)</span>
                    </label>
                </div>
            </div>

            @if($upload_type === 'single')
                <div class="form-group">
                    <label class="form-label">Config Content</label>
                    <textarea wire:model="content" class="form-input" rows="4"
                        placeholder="Paste config here..."></textarea>
                    @error('content') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            @else
                <div class="form-group">
                    <label class="form-label">Bulk Configs</label>
                    <textarea wire:model="bulk_content" class="form-input" rows="10"
                        placeholder="Paste many configs here..."></textarea>
                    <small class="text-muted">Make sure to select the correct separator below.</small>
                    @error('bulk_content') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Separator</label>
                    <select wire:model="separator" class="form-select">
                        <option value="newline">New Line (Each config on new line)</option>
                        <option value="comma">Comma (,)</option>
                        <option value="semicolon">Semicolon (;)</option>
                    </select>
                    @error('separator') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="form-actions" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <span wire:loading.remove>Save Configs</span>
                    <span wire:loading>Saving...</span>
                </button>
                <a href="{{ route('admin.configs.index') }}" class="btn btn-secondary" wire:navigate>Cancel</a>
            </div>
        </form>
    </div>
</div>