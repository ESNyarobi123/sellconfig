@extends('layouts.admin')

@section('title', 'Configs')
@section('header', '🔐 Manage Configs')

@section('content')
    <!-- Filter Bar -->
    <div class="admin-card">
        <div class="admin-card-body">
            <form action="{{ route('admin.configs.index') }}" method="GET">
                <div class="filter-bar">
                    <select name="plan_id" class="form-input form-select" onchange="this.form.submit()">
                        <option value="">-- Chagua Plan --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} ({{ $plan->configs()->where('status', 'available')->count() }} available)
                            </option>
                        @endforeach
                    </select>

                    @if($selectedPlan)
                        <a href="{{ route('admin.configs.create', ['plan_id' => $selectedPlan->id]) }}"
                            class="btn btn-primary btn-sm" style="width: auto;">
                            ➕ Add Configs
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($selectedPlan)
        <!-- Plan Info -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">📦 {{ $selectedPlan->name }}</h3>
                <div class="action-buttons">
                    <span class="status-badge status-available">{{ $selectedPlan->availableConfigsCount() }} Available</span>
                    <span class="status-badge status-sold">{{ $selectedPlan->soldConfigsCount() }} Sold</span>
                </div>
            </div>
            <div class="admin-card-body" style="padding: 0;">
                @if(!$configs || $configs->count() === 0)
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3 class="empty-title">No Configs Yet</h3>
                        <p class="empty-text">Plan hii haina configs. Ongeza configs sasa.</p>
                        <a href="{{ route('admin.configs.create', ['plan_id' => $selectedPlan->id]) }}" class="btn btn-primary"
                            style="width: auto;">
                            ➕ Add Configs
                        </a>
                    </div>
                @else
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Content (Preview)</th>
                                    <th>Status</th>
                                    <th>Sold To</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($configs as $config)
                                    <tr>
                                        <td>{{ $config->id }}</td>
                                        <td>
                                            <code style="font-size: 0.75rem; color: var(--accent-primary);">
                                                                            {{ Str::limit($config->content, 60) }}
                                                                        </code>
                                        </td>
                                        <td>
                                            @if($config->status === 'available')
                                                <span class="status-badge status-available">Available</span>
                                            @else
                                                <span class="status-badge status-sold">Sold</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($config->soldToUser)
                                                {{ $config->soldToUser->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $config->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                @if($config->status === 'available')
                                                    <a href="{{ route('admin.configs.edit', $config) }}" class="btn btn-edit btn-sm"
                                                        title="Edit">
                                                        ✏️
                                                    </a>
                                                    <form action="{{ route('admin.configs.destroy', $config) }}" method="POST"
                                                        style="display: inline;" onsubmit="return confirm('Futa config hii?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                            🗑️
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="padding: var(--spacing-lg);">
                        {{ $configs->appends(['plan_id' => $selectedPlan->id])->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Danger Zone -->
        @if($selectedPlan->availableConfigsCount() > 0)
            <div class="admin-card" style="border-color: var(--error);">
                <div class="admin-card-header" style="border-color: rgba(239, 68, 68, 0.3);">
                    <h3 class="admin-card-title" style="color: var(--error);">⚠️ Danger Zone</h3>
                </div>
                <div class="admin-card-body">
                    <p class="text-muted mb-3">Futa configs zote ambazo hazijauzwa.</p>
                    <form action="{{ route('admin.configs.destroyAll') }}" method="POST"
                        onsubmit="return confirm('Una uhakika? Hii itafuta configs ZOTE zilizo available!')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="plan_id" value="{{ $selectedPlan->id }}">
                        <button type="submit" class="btn btn-danger" style="width: auto;">
                            🗑️ Delete All Available Configs ({{ $selectedPlan->availableConfigsCount() }})
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="admin-card">
            <div class="empty-state">
                <div class="empty-icon">👆</div>
                <h3 class="empty-title">Chagua Plan</h3>
                <p class="empty-text">Chagua plan kutoka dropdown hapo juu kuona configs zake.</p>
            </div>
        </div>
    @endif
@endsection