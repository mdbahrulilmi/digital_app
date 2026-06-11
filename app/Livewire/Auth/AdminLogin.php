<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password])) {
            request()->session()->regenerate();
            return redirect()->to('/admin/landing-page');
        }

        session()->flash('error', 'Email atau password Admin salah.');
    }

    public function render()
    {
        return view('livewire.auth.admin-login')->layout('layouts.public');
    }
}