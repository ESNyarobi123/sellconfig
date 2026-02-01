<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function toggleStatus($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['is_active' => !$user->is_active]);
            session()->flash('success', 'Hali ya mtumiaji imebadilishwa.');
        }
    }

    public function render()
    {
        $users = User::where('role', 'user')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->withCount([
                'orders' => function ($query) {
                    $query->where('payment_status', 'completed');
                }
            ])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('livewire.admin.users.index', [
            'users' => $users
        ])->layout('layouts.admin');
    }
}
