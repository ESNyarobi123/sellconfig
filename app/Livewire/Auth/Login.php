<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $phone;
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['phone' => $this->phone, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended(route('home'));
        }

        $this->addError('phone', 'Namba ya simu au password siyo sahihi.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.app');
    }
}
