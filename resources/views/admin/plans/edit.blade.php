@extends('layouts.admin')

@section('title', 'Edit Plan')
@section('header', '✏️ Edit Plan')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">📦 Edit: {{ $plan->name }}</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.plans.update', $plan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="form-label" for="name">Plan Name *</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $plan->name) }}"
                            required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="form-label" for="price">Price (TZS) *</label>
                        <input type="number" id="price" name="price" class="form-input"
                            value="{{ old('price', $plan->price) }}" min="100" required>
                        @error('price')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="form-label" for="duration">Duration</label>
                        <input type="text" id="duration" name="duration" class="form-input"
                            value="{{ old('duration', $plan->duration) }}">
                        @error('duration')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="form-label" for="image">Plan Image</label>
                        @if($plan->image)
                            <div style="margin-bottom: var(--spacing-sm);">
                                <img src="{{ asset('storage/' . $plan->image) }}" alt=""
                                    style="max-width: 100px; border-radius: var(--radius-sm);">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" class="form-input" accept="image/*">
                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-input form-textarea"
                        rows="3">{{ old('description', $plan->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="admin-form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ $plan->is_active ? 'checked' : '' }}>
                        <span>Active (Visible to users)</span>
                    </label>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary" style="width: auto;">
                        💾 Update Plan
                    </button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary" style="width: auto;">
                        ❌ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection