@extends('layouts.admin')

@section('title', 'Create Plan')
@section('header', '➕ Create New Plan')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">📦 Plan Details</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.plans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="form-label" for="name">Plan Name *</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}"
                            placeholder="Mfano: Vodacom 1 Month" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="form-label" for="price">Price (TZS) *</label>
                        <input type="number" id="price" name="price" class="form-input" value="{{ old('price') }}"
                            placeholder="5000" min="100" required>
                        @error('price')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="form-label" for="duration">Duration</label>
                        <input type="text" id="duration" name="duration" class="form-input" value="{{ old('duration') }}"
                            placeholder="Mfano: 1 Month, 1 Week">
                        @error('duration')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="form-label" for="image">Plan Image</label>
                        <input type="file" id="image" name="image" class="form-input" accept="image/*">
                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-input form-textarea" rows="3"
                        placeholder="Maelezo ya plan...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary" style="width: auto;">
                        💾 Create Plan
                    </button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary" style="width: auto;">
                        ❌ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection