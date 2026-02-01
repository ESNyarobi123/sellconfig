<div>
    <div style="margin-bottom: 2rem;">
        <!-- Tabs -->
        <div class="tabs-container"
            style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
            <button wire:click="setTab('week_1')" class="tab-btn {{ $activeTab === 'week_1' ? 'active' : '' }}">
                📅 1 WEEK
            </button>
            <button wire:click="setTab('week_2')" class="tab-btn {{ $activeTab === 'week_2' ? 'active' : '' }}">
                📅 2 WEEKS
            </button>
            <button wire:click="setTab('month_1')" class="tab-btn {{ $activeTab === 'month_1' ? 'active' : '' }}">
                📅 1 MONTH (30 Days)
            </button>
            <button wire:click="setTab('other')" class="tab-btn {{ $activeTab === 'other' ? 'active' : '' }}">
                📂 OTHER
            </button>
        </div>

        <!-- Loading State -->
        <div wire:loading class="loading-state"
            style="text-align: center; color: var(--accent-primary); padding: 2rem;">
            Loading...
        </div>

        <!-- Plans Grid -->
        <div wire:loading.remove>
            @if($plans->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3 class="empty-title">Hakuna Plans Kwa Group Hii</h3>
                    <p class="empty-text">Tafadhali chagua group lingine.</p>
                </div>
            @else
                <div class="plans-grid">
                    @foreach($plans as $plan)
                        <div class="plan-card blue-theme">
                            @if($plan->image)
                                <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->name }}" class="plan-image">
                            @else
                                <div class="plan-image"
                                    style="display: flex; align-items: center; justify-content: center; font-size: 3rem; background: rgba(255,255,255,0.5);">
                                    📡
                                </div>
                            @endif

                            <h3 class="plan-name" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $plan->name }}</h3>

                            @if($plan->duration)
                                <span class="plan-duration"
                                    style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.3);">{{ $plan->duration }}</span>
                            @endif

                            <p class="plan-description" style="color: #e2e8f0;">
                                {{ $plan->description ?? 'VPN config ya kuaminika na ya haraka.' }}
                            </p>

                            <div class="plan-price">
                                <span style="font-size: 0.8rem; color: #cbd5e1;">TZS</span>
                                <span
                                    style="color: #60a5fa; font-weight: 800; text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);">{{ number_format((float) $plan->price, 0, '.', ',') }}</span>
                                <span style="font-size: 0.7rem; color: #cbd5e1;">/ config</span>
                            </div>

                            <div class="plan-stock">
                                @if($plan->available_count > 0)
                                    <span class="stock-indicator available" style="background: #4ade80; box-shadow: 0 0 10px #4ade80;"></span>
                                    <span class="stock-count" style="color: #4ade80;">{{ $plan->available_count }} in
                                        stock</span>
                                @else
                                    <span class="stock-indicator out"></span>
                                    <span class="stock-text stock-out" style="color: #f87171;">Zimeisha</span>
                                @endif
                            </div>

                            @if($plan->available_count > 0)
                                <a href="{{ route('plan.checkout', $plan) }}" class="btn btn-primary"
                                    style="background: linear-gradient(to right, #2563eb, #1d4ed8); border: none; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);">
                                    <span>🛒</span> Nunua
                                </a>
                            @else
                                <button class="btn btn-primary" disabled
                                    style="background: #cbd5e0; border: none; cursor: not-allowed;">
                                    <span>❌</span> Imeisha
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Blue Theme Plan Card */
        /* Blue Theme Plan Card */
        .plan-card.blue-theme {
            background: linear-gradient(135deg, rgba(16, 52, 166, 0.8) 0%, rgba(37, 99, 235, 0.4) 100%);
            border: 1px solid rgba(147, 197, 253, 0.3);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .plan-card.blue-theme:hover {
            background: #DCEEFF;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Tabs Styling */
        .tab-btn {
            background: transparent;
            border: 1px solid var(--accent-primary);
            color: var(--accent-primary);
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            cursor: pointer;
            font-family: var(--font-display);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .tab-btn:hover {
            background: rgba(102, 252, 241, 0.1);
        }

        .tab-btn.active {
            background: var(--accent-gradient);
            color: var(--bg-primary);
            border-color: transparent;
            box-shadow: 0 0 15px rgba(102, 252, 241, 0.5);
        }
    </style>
</div>