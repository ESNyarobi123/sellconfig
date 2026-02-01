@section('title', 'Edit Plan')
@section('header', '✏️ Edit Plan')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="admin-card-body">
        <form wire:submit="update">
            <div class="form-group">
                <label class="form-label" for="name">Plan Name</label>
                <input type="text" id="name" wire:model="name" class="form-input" required>
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
                    <input type="number" id="price" wire:model="price" class="form-input" required min="100">
                    @error('price') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="duration">Display Duration</label>
                <input type="text" id="duration" wire:model="duration" class="form-input">
                @error('duration') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" wire:model="is_active">
                    <span>Active (Visible on Homepage)</span>
                </label>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" wire:model="description" class="form-input" rows="3"></textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="image">Plan Image</label>
                <input type="file" id="image" wire:model="image" class="form-input" accept="image/*">
                <div wire:loading wire:target="image" class="text-muted">Uploading...</div>
                @error('image') <span class="form-error">{{ $message }}</span> @enderror

                @if ($image)
                    <div style="margin-top: 1rem;">
                        <p class="text-muted mb-1">New Image:</p>
                        <img src="{{ $image->temporaryUrl() }}" alt="New Preview"
                            style="max-height: 200px; border-radius: 8px;">
                    </div>
                @elseif($plan->image)
                    <div style="margin-top: 1rem;">
                        <p class="text-muted mb-1">Current Image:</p>
                        <img src="{{ asset('storage/' . $plan->image) }}" alt="Current Image"
                            style="max-height: 200px; border-radius: 8px;">
                    </div>
                @endif
            </div>

            <div class="form-actions" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <span wire:loading.remove>Update Plan</span>
                    <span wire:loading>Updating...</span>
                </button>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary" wire:navigate>Cancel</a>
            </div>
        </form>
    </div>
</div>