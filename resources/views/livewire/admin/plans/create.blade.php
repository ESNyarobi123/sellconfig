@section('title', 'Create Plan')
@section('header', '➕ Create New Plan')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="admin-card-body">
        <form wire:submit="save">
            <div class="form-group">
                <label class="form-label" for="name">Plan Name</label>
                <input type="text" id="name" wire:model="name" class="form-input" placeholder="e.g. VIP Weekly"
                    required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="type">Plan Type</label>
                    <select id="type" wire:model="type" class="form-select">
                        <option value="weekly">Weekly (7 Days)</option>
                        <option value="bi_weekly">Bi-Weekly (14 Days)</option>
                        <option value="monthly">Monthly (30 Days)</option>
                    </select>
                    @error('type') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="price">Price (TZS)</label>
                    <input type="number" id="price" wire:model="price" class="form-input" placeholder="e.g. 2000"
                        required min="100">
                    @error('price') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="duration">Display Duration</label>
                <input type="text" id="duration" wire:model="duration" class="form-input" placeholder="e.g. Siku 7">
                <small class="text-muted">Text to verify on card (optional)</small>
                @error('duration') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" wire:model="description" class="form-input" rows="3"
                    placeholder="Plan details..."></textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="image">Plan Image</label>
                <input type="file" id="image" wire:model="image" class="form-input" accept="image/*">
                <div wire:loading wire:target="image" class="text-muted">Uploading...</div>
                @error('image') <span class="form-error">{{ $message }}</span> @enderror

                @if ($image)
                    <div style="margin-top: 1rem;">
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                            style="max-height: 200px; border-radius: 8px;">
                    </div>
                @endif
            </div>

            <div class="form-actions" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <span wire:loading.remove>Save Plan</span>
                    <span wire:loading>Saving...</span>
                </button>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary" wire:navigate>Cancel</a>
            </div>
        </form>
    </div>
</div>