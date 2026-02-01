@section('title', 'Plans')
@section('header', '📦 Plans Management')

<div>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">All Plans</h3>
            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary" wire:navigate>
                ➕ Add New Plan
            </a>
        </div>
        <div class="admin-card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Stock (Available/Total)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr wire:key="plan-{{ $plan->id }}">
                                <td>
                                    @if($plan->image)
                                        <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->name }}"
                                            class="table-image"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div
                                            style="width: 50px; height: 50px; background: rgba(0,0,0,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            📡
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $plan->name }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $plan->duration }}</div>
                                </td>
                                <td>
                                    @if($plan->type === 'weekly')
                                        <span class="status-badge"
                                            style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">Weekly</span>
                                    @elseif($plan->type === 'bi_weekly')
                                        <span class="status-badge"
                                            style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">Bi-Weekly</span>
                                    @elseif($plan->type === 'monthly')
                                        <span class="status-badge"
                                            style="background: rgba(16, 185, 129, 0.1); color: #10b981;">Monthly</span>
                                    @else
                                        <span class="status-badge">{{ $plan->type }}</span>
                                    @endif
                                </td>
                                <td>TZS {{ number_format((float) $plan->price, 0) }}</td>
                                <td>
                                    <span class="{{ $plan->available_configs > 0 ? 'text-success' : 'text-danger' }}"
                                        style="font-weight: bold;">
                                        {{ $plan->available_configs }}
                                    </span>
                                    / {{ $plan->total_configs }}
                                </td>
                                <td>
                                    <button wire:click="toggleStatus({{ $plan->id }})"
                                        class="status-badge {{ $plan->is_active ? 'status-completed' : 'status-failed' }}"
                                        style="border: none; cursor: pointer;">
                                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-secondary btn-sm"
                                            wire:navigate>
                                            ✏️ Edit
                                        </a>
                                        <button wire:click="delete({{ $plan->id }})"
                                            wire:confirm="Are you sure you want to delete this plan?"
                                            class="btn btn-danger btn-sm"
                                            style="background: #ef4444; color: white; border: none;">
                                            🗑️ Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted" style="padding: 2rem;">
                                    No plans found. Create one to get started!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>