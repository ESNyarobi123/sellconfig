@extends('layouts.admin')

@section('title', 'Plans')
@section('header', '📦 Manage Plans')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">📦 All Plans</h3>
            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary btn-sm" style="width: auto;">
                ➕ Add Plan
            </a>
        </div>

        <!-- Category Tabs -->
        <div
            style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('admin.plans.index', ['type' => 'all']) }}"
                class="tab-filter-btn {{ $type === 'all' ? 'active' : '' }}">
                📋 All
            </a>
            <a href="{{ route('admin.plans.index', ['type' => 'weekly']) }}"
                class="tab-filter-btn {{ $type === 'weekly' ? 'active' : '' }}">
                📅 Weekly
            </a>
            <a href="{{ route('admin.plans.index', ['type' => 'bi_weekly']) }}"
                class="tab-filter-btn {{ $type === 'bi_weekly' ? 'active' : '' }}">
                📅 Bi-Weekly
            </a>
            <a href="{{ route('admin.plans.index', ['type' => 'monthly']) }}"
                class="tab-filter-btn {{ $type === 'monthly' ? 'active' : '' }}">
                📅 Monthly
            </a>
            <a href="{{ route('admin.plans.index', ['type' => 'other']) }}"
                class="tab-filter-btn {{ $type === 'other' ? 'active' : '' }}">
                📂 Other
            </a>
        </div>

        <style>
            .tab-filter-btn {
                padding: 0.5rem 1rem;
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                background: rgba(0, 0, 0, 0.2);
                color: rgba(255, 255, 255, 0.7);
                text-decoration: none;
                font-weight: 500;
                font-size: 0.85rem;
                transition: all 0.3s ease;
                display: inline-block;
            }

            .tab-filter-btn:hover {
                background: rgba(102, 252, 241, 0.1);
                border-color: rgba(102, 252, 241, 0.3);
                color: #fff;
            }

            .tab-filter-btn.active {
                background: linear-gradient(90deg, #00C6FF 0%, #0072FF 100%);
                border-color: transparent;
                color: #fff;
                box-shadow: 0 2px 8px rgba(0, 114, 255, 0.4);
            }
        </style>

        <div class="admin-card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Stock</th>
                            <th>Sold</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>
                                    <strong>{{ $plan->name }}</strong>
                                </td>
                                <td>TZS {{ number_format($plan->price, 0) }}</td>
                                <td>{{ $plan->duration ?? '-' }}</td>
                                <td>
                                    <span class="{{ $plan->available_configs > 0 ? 'text-success' : 'text-error' }}">
                                        {{ $plan->available_configs }}
                                    </span>
                                </td>
                                <td>{{ $plan->sold_configs }}</td>
                                <td>
                                    @if($plan->is_active)
                                        <span class="status-badge status-available">Active</span>
                                    @else
                                        <span class="status-badge status-sold">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.configs.index', ['plan_id' => $plan->id]) }}"
                                            class="btn btn-secondary btn-sm" title="View Configs">
                                            🔐
                                        </a>
                                        <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-edit btn-sm"
                                            title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('admin.plans.toggle', $plan) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm" title="Toggle Status">
                                                {{ $plan->is_active ? '🔒' : '🔓' }}
                                            </button>
                                        </form>
                                        @if($plan->sold_configs == 0)
                                            <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Una uhakika unataka kufuta plan hii?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    🗑️
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No plans yet. <a href="{{ route('admin.plans.create') }}"
                                        style="color: var(--accent-primary);">Create one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection