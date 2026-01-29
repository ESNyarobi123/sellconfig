@extends('layouts.admin')

@section('title', 'Users')
@section('header', '👥 Manage Users')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">👥 All Users</h3>
        </div>
        <div class="admin-card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->orders_count }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="status-badge status-available">Active</span>
                                    @else
                                        <span class="status-badge status-sold">Blocked</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            class="btn {{ $user->is_active ? 'btn-danger' : 'btn-primary' }} btn-sm">
                                            {{ $user->is_active ? '🔒 Block' : '🔓 Unblock' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No users yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="padding: var(--spacing-lg);">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection