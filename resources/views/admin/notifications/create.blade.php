@extends('layouts.admin')

@section('title', 'Send Notifications')
@section('header', '🔔 Send Push Notification')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">📨 Compose Notification</h3>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary btn-sm" style="width: auto;">
                📜 View History
            </a>
        </div>
        <div class="admin-card-body">
            @if(!env('VAPID_PUBLIC_KEY'))
                <div class="admin-alert alert-error" style="margin-bottom: 20px;">
                    ⚠️ VAPID Keys hazijawekwa kwenye .env! Notifications hazitatumwa.
                </div>
            @endif

            <form action="{{ route('admin.notifications.send') }}" method="POST">
                @csrf

                <div class="admin-form-group">
                    <label class="form-label" for="title">Title (Kichwa) *</label>
                    <input type="text" id="title" name="title" class="form-input"
                        placeholder="e.g. Habari Njema! Punguzo la Bei" required>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="body">Message (Ujumbe) *</label>
                    <textarea id="body" name="body" class="form-input form-textarea" rows="4"
                        placeholder="Andika ujumbe mfupi hapa..." required></textarea>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="url">Target URL (Optional)</label>
                    <input type="url" id="url" name="url" class="form-input" placeholder="https://example.com/plan/1">
                    <small style="color: var(--text-muted)">Ukiacha wazi, itafungua home page.</small>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                    🚀 Send Broadcast
                </button>
            </form>
        </div>
    </div>
@endsection