<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
    use WithPagination;

    // Use bootstrap theme for pagination as per Laravel defaults or custom if needed
    protected $paginationTheme = 'simple';

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['plan', 'config'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.user.history', [
            'orders' => $orders
        ])->layout('layouts.app');
    }
}
