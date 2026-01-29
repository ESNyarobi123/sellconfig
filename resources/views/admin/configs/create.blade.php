@extends('layouts.admin')

@section('title', 'Add Configs')
@section('header', '➕ Add Configs')

@section('content')
    <!-- Single Config -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">➕ Add Single Config</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.configs.store') }}" method="POST">
                @csrf

                <div class="admin-form-group">
                    <label class="form-label" for="plan_id">Select Plan *</label>
                    <select name="plan_id" id="plan_id" class="form-input form-select" required>
                        <option value="">-- Chagua Plan --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ $selectedPlanId == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - TZS {{ number_format($plan->price, 0) }}
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="content">Config Content *</label>
                    <textarea name="content" id="content" class="form-input form-textarea" rows="4"
                        placeholder="Weka config content hapa..." required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: auto;">
                    💾 Add Config
                </button>
            </form>
        </div>
    </div>

    <!-- Bulk Upload -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">📤 Bulk Upload Configs</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.configs.bulk') }}" method="POST">
                @csrf

                <div class="admin-form-group">
                    <label class="form-label" for="bulk_plan_id">Select Plan *</label>
                    <select name="plan_id" id="bulk_plan_id" class="form-input form-select" required>
                        <option value="">-- Chagua Plan --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ $selectedPlanId == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - TZS {{ number_format($plan->price, 0) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="separator">Separator</label>
                    <select name="separator" id="separator" class="form-input form-select">
                        <option value="newline">New Line (kila mstari = config moja)</option>
                        <option value="comma">Comma (,)</option>
                        <option value="semicolon">Semicolon (;)</option>
                    </select>
                    <small class="text-muted">Jinsi configs zako zimegawanywa</small>
                </div>

                <div class="admin-form-group">
                    <label class="form-label" for="configs">Paste Configs *</label>
                    <textarea name="configs" id="configs" class="form-input form-textarea" rows="10" placeholder="Weka configs nyingi hapa, zimetenganishwa kwa separator ulichochagua hapo juu...

    Mfano (kwa new line):
    config1_text_here
    config2_text_here
    config3_text_here" required></textarea>
                    <small class="text-muted">Kila config itahifadhiwa kama available.</small>
                </div>

                <button type="submit" class="btn btn-primary" style="width: auto;">
                    📤 Upload All Configs
                </button>
            </form>
        </div>
    </div>

    <div class="action-buttons mt-4">
        <a href="{{ route('admin.configs.index', ['plan_id' => $selectedPlanId]) }}" class="btn btn-secondary"
            style="width: auto;">
            ⬅️ Back to Configs
        </a>
    </div>
@endsection