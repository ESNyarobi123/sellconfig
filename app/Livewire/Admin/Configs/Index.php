<?php

namespace App\Livewire\Admin\Configs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Config;
use App\Models\Plan;

class Index extends Component
{
    use WithPagination;

    public $selectedPlanId;
    public $filterStatus = 'all';

    protected $queryString = ['selectedPlanId'];

    public function mount()
    {
        // Don't auto-select a plan, let user choose from dashboard link or dropdown
    }

    public function delete($configId)
    {
        $config = Config::find($configId);
        if ($config && $config->status !== 'sold') {
            $config->delete();
            session()->flash('success', 'Config imefutwa.');
        } else {
            session()->flash('error', 'Huwezi kufuta config iliyouzwa au haipo.');
        }
    }

    public function deleteAllAvailable()
    {
        if ($this->selectedPlanId) {
            $deleted = Config::where('plan_id', $this->selectedPlanId)
                ->where('status', 'available')
                ->delete();

            session()->flash('success', "Available Configs {$deleted} zimefutwa.");
        }
    }

    public function render()
    {
        $plans = Plan::all();

        $configs = null;
        if ($this->selectedPlanId) {
            $query = Config::where('plan_id', $this->selectedPlanId)
                ->with('soldToUser')
                ->orderByDesc('created_at');

            if ($this->filterStatus !== 'all') {
                $query->where('status', $this->filterStatus);
            }

            $configs = $query->paginate(20);
        }

        return view('livewire.admin.configs.index', [
            'plans' => $plans,
            'configs' => $configs
        ])->layout('layouts.admin');
    }
}
