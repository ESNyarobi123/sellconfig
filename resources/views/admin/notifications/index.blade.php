@extends('layouts.admin')

@section('title', 'Notification History')
@section('header', '📜 History ya Notifications')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">📦 Zilizotumwa</h3>
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-sm" style="width: auto;">
                ➕ New Broadcast
            </a>
        </div>
        <div class="admin-card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tarehe</th>
                            <th>Ujumbe</th>
                            <th>Stats (Success/Fail)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        {{ $message->created_at->format('d M, Y') }}<br>
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--accent-primary);">{{ $message->title }}</div>
                                    <div style="font-size: 0.85rem; color: #a0a0a0;">{{ Str::limit($message->body, 50) }}</div>
                                </td>
                                <td>
                                    <span class="status-badge status-available"
                                        style="background: rgba(0, 255, 0, 0.1); color: #00ff00;">
                                        ✅ {{ $message->success_count }}
                                    </span>
                                    <span class="status-badge status-sold"
                                        style="background: rgba(255, 0, 0, 0.1); color: #ff4d4d;">
                                        ❌ {{ $message->failure_count }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.notifications.resend', $message) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm" title="Tuma Tena">
                                            🔄 Resend
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Bado hujatuma notification yoyote.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="padding: 1rem;">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
@endsection