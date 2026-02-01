<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name;
    public $phone;
    public $password;
    public $password_confirmation;

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^0[0-9]{9}$/', 'unique:users'],
            'password' => 'required|string|min:6|confirmed',
        ], [
            'phone.regex' => 'Namba ya simu lazima ianze na 0 na iwe na tarakimu 10.',
            'phone.unique' => 'Namba hii imesajiliwa tayari.',
            'password.min' => 'Password lazima iwe na angalau herufi 6.',
            'password.confirmed' => 'Password hazifanani.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.app');
    }
}
