<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Plan;

class Index extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $filterPlan = '';

    public function render()
    {
        $query = Order::with(['user', 'plan', 'config'])
            ->orderByDesc('created_at');

        if ($this->filterStatus) {
            $query->where('payment_status', $this->filterStatus);
        }

        if ($this->filterPlan) {
            $query->where('plan_id', $this->filterPlan);
        }

        $orders = $query->paginate(20);
        $plans = Plan::all();

        return view('livewire.admin.sales.index', [
            'orders' => $orders,
            'plans' => $plans
        ])->layout('layouts.admin');
    }
}
