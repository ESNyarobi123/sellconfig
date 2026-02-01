<?php

namespace App\Livewire\Admin\Plans;

use Livewire\Component;
use App\Models\Plan;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    public function toggleStatus($planId)
    {
        $plan = Plan::find($planId);
        if ($plan) {
            $plan->update(['is_active' => !$plan->is_active]);
            session()->flash('success', 'Hali ya plan imebadilishwa.');
        }
    }

    public function delete($planId)
    {
        $plan = Plan::find($planId);
        if (!$plan)
            return;

        // Check if plan has sold configs
        if ($plan->configs()->where('status', 'sold')->exists()) {
            session()->flash('error', 'Huwezi kufuta plan ambayo ina configs zilizouzwa.');
            return;
        }

        if ($plan->image) {
            Storage::disk('public')->delete($plan->image);
        }

        $plan->delete();
        session()->flash('success', 'Plan imefutwa.');
    }

    public function render()
    {
        $plans = Plan::withCount([
            'configs as total_configs',
            'configs as available_configs' => function ($query) {
                $query->where('status', 'available');
            },
            'configs as sold_configs' => function ($query) {
                $query->where('status', 'sold');
            },
        ])->orderByDesc('created_at')->get();

        return view('livewire.admin.plans.index', [
            'plans' => $plans
        ])->layout('layouts.admin');
    }
}
