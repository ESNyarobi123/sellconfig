<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Plan;

class PlanList extends Component
{
    public $activeTab = 'week_1'; // Defaults to 7 days

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $plans = Plan::where('is_active', true)
            ->where('group_key', $this->activeTab)
            ->withCount([
                'configs as available_count' => function ($query) {
                    $query->where('status', 'available');
                }
            ])
            ->orderBy('price')
            ->get();

        return view('livewire.plan-list', [
            'plans' => $plans
        ]);
    }
}
