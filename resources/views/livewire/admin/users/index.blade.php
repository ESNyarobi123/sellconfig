@section('title', 'Manage Users')
@section('header', '👥 Users Management')

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Registered Users</h3>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 Search users..." class="form-input"
            style="width: 250px;">
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Purchases</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td>{{ $user->id }}</td>
                            <td style="font-weight: 500;">{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <span class="status-badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    {{ $user->orders_count }} Orders
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="status-badge status-completed">Active</span>
                                @else
                                    <span class="status-badge status-failed">Blocked</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="toggleStatus({{ $user->id }})"
                                    class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-primary' }}"
                                    style="{{ $user->is_active ? 'background: #ef4444;' : '' }}">
                                    {{ $user->is_active ? 'Block' : 'Unblock' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 2rem;">
                                No users found matching your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination" style="margin-top: 1rem;">
            {{ $users->links() }}
        </div>
    </div>
</div>