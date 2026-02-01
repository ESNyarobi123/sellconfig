@section('title', 'Manage Configs')
@section('header', '🔐 Configs Management')

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Filter Configs</h3>
        @if($selectedPlanId)
            <div class="action-buttons">
                <a href="{{ route('admin.configs.create', ['plan_id' => $selectedPlanId]) }}" class="btn btn-primary btn-sm"
                    wire:navigate>
                    ➕ Add Configs for This Plan
                </a>
                <button wire:click="deleteAllAvailable"
                    wire:confirm="Je, una uhakika unataka kufuta configs zote zilizopo 'Available' kwa plan hii?"
                    class="btn btn-danger btn-sm">
                    🗑️ Delete All Available
                </button>
            </div>
        @endif
    </div>

    <div class="admin-card-body">
        <div class="grid-2" style="margin-bottom: 2rem;">
            <div class="form-group">
                <label class="form-label">Select Plan to View</label>
                <select wire:model.live="selectedPlanId" class="form-select">
                    <option value="">-- Choose a Plan --</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->id }} - {{ $plan->name }}
                            ({{ number_format((float) $plan->price) }} TZS)</option>
                    @endforeach
                </select>
            </div>

            @if($selectedPlanId)
                <div class="form-group">
                    <label class="form-label">Filter Status</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="all">All Status</option>
                        <option value="available">Available (In Stock)</option>
                        <option value="sold">Sold</option>
                    </select>
                </div>
            @endif
        </div>

        @if($selectedPlanId && $configs)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Content (Preview)</th>
                            <th>Status</th>
                            <th>Added At</th>
                            <th>Sold Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($configs as $config)
                            <tr wire:key="config-{{ $config->id }}">
                                <td>
                                    <code style="background: #f1f5f9; padding: 2px 4px; border-radius: 4px; color: #334155;">
                                                        {{ Str::limit($config->content, 50) }}
                                                    </code>
                                </td>
                                <td>
                                    @if($config->status === 'available')
                                        <span class="status-badge status-completed">Available</span>
                                    @else
                                        <span class="status-badge status-pending">Sold</span>
                                    @endif
                                </td>
                                <td>{{ $config->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($config->sold_at)
                                        {{ $config->sold_at->format('d/m/Y H:i') }} <br>
                                        <small class="text-muted">By: {{ $config->soldToUser->name ?? 'Unknown' }}</small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($config->status !== 'sold')
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.configs.edit', $config) }}" class="btn btn-secondary btn-sm"
                                                wire:navigate>✏️</a>
                                            <button wire:click="delete({{ $config->id }})" wire:confirm="Are you sure?"
                                                class="btn btn-danger btn-sm" style="padding: 0.25rem 0.6rem;">🗑️</button>
                                        </div>
                                    @else
                                        <span class="text-muted">Sold</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding: 2rem;">
                                    No configs found for this filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination" style="margin-top: 1rem;">
                {{ $configs->links() }}
            </div>
        @elseif(!$selectedPlanId)
            <div class="empty-state">
                <h3 class="empty-title">👆 Select a Plan</h3>
                <p class="empty-text">Choose a plan from the dropdown above to manage its configs.</p>
            </div>
        @endif
    </div>
</div>