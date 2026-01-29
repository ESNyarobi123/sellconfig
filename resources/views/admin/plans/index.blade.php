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