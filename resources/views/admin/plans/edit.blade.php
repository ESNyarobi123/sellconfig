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
                        <label class="form-label" for="type">Category (Type) *</label>
                        <select id="type" name="type" class="form-input" required onchange="toggleDurationDays()">
                            <option value="">Chagua Aina</option>
                            <option value="weekly" {{ old('type', $plan->type) == 'weekly' ? 'selected' : '' }}>Weekly (Wiki)
                            </option>
                            <option value="bi_weekly" {{ old('type', $plan->type) == 'bi_weekly' ? 'selected' : '' }}>
                                Bi-Weekly (Wiki 2)</option>
                            <option value="monthly" {{ old('type', $plan->type) == 'monthly' ? 'selected' : '' }}>Monthly
                                (Mwezi)</option>
                            <option value="other" {{ old('type', $plan->type) == 'other' ? 'selected' : '' }}>Other (Nyingine)
                            </option>
                        </select>
                        @error('type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Duration Days - Only for 'Other' type -->
                @php
                    $showDurationDays = old('type', $plan->type) == 'other' ? 'flex' : 'none';
                @endphp
                <div class="admin-form-row" id="duration-days-row" style="display: {{ $showDurationDays }};">
                    <div class="admin-form-group">
                        <label class="form-label" for="duration_days">Duration Days (Siku) *</label>
                        <input type="number" id="duration_days" name="duration_days" class="form-input"
                            value="{{ old('duration_days', $plan->duration_days) }}" placeholder="Mfano: 90" min="1"
                            max="365">
                        <small style="color: var(--text-muted); font-size: 0.8rem;">Weka idadi ya siku kwa plan hii
                            (1-365)</small>
                        @error('duration_days')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <script>
                    function toggleDurationDays() {
                        var type = document.getElementById('type').value;
                        var durationDaysRow = document.getElementById('duration-days-row');
                        var durationDaysInput = document.getElementById('duration_days');

                        if (type === 'other') {
                            durationDaysRow.style.display = 'flex';
                            durationDaysInput.required = true;
                        } else {
                            durationDaysRow.style.display = 'none';
                            durationDaysInput.required = false;
                        }
                    }
                    // Run on page load
                    document.addEventListener('DOMContentLoaded', toggleDurationDays);
                </script>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="form-label" for="price">Price (TZS) *</label>
                        <input type="number" id="price" name="price" class="form-input"
                            value="{{ old('price', $plan->price) }}" min="100" required>
                        @error('price')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="form-label" for="duration">Duration</label>
                        <input type="text" id="duration" name="duration" class="form-input"
                            value="{{ old('duration', $plan->duration) }}">
                        @error('duration')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-row">
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