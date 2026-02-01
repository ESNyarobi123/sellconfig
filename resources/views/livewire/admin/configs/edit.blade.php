@section('title', 'Edit Config')
@section('header', '✏️ Edit Config')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="admin-card-body">
        <form wire:submit="update">
            <div class="form-group">
                <label class="form-label">Plan</label>
                <input type="text" class="form-input" value="{{ $config->plan->name }}" disabled
                    style="background: #f1f5f9; cursor: not-allowed;">
            </div>

            <div class="form-group">
                <label class="form-label">Config Content</label>
                <textarea wire:model="content" class="form-input" rows="6"></textarea>
                @error('content') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <span wire:loading.remove>Update Config</span>
                    <span wire:loading>Updating...</span>
                </button>
                <a href="{{ route('admin.configs.index', ['selectedPlanId' => $config->plan_id]) }}"
                    class="btn btn-secondary" wire:navigate>Cancel</a>
            </div>
        </form>
    </div>
</div>