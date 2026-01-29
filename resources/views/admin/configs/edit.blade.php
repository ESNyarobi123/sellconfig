@extends('layouts.admin')

@section('title', 'Edit Config')
@section('header', '✏️ Edit Config')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">🔐 Edit Config #{{ $config->id }}</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.configs.update', $config) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="admin-form-group">
                    <label class="form-label">Plan</label>
                    <input type="text" class="form-input" value="{{ $config->plan->name }}" disabled>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="content">Config Content *</label>
                    <textarea name="content" id="content" class="form-input form-textarea" rows="8"
                        required>{{ old('content', $config->content) }}</textarea>
                    @error('content')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary" style="width: auto;">
                        💾 Update Config
                    </button>
                    <a href="{{ route('admin.configs.index', ['plan_id' => $config->plan_id]) }}" class="btn btn-secondary"
                        style="width: auto;">
                        ❌ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection