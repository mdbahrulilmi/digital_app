<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MemberLogin extends Component
{
    public $whatsapp;
    public $password;

    protected $rules = [
        'whatsapp' => 'required|numeric',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::guard('member')->attempt(['whatsapp' => $this->whatsapp, 'password' => $this->password])) {
            request()->session()->regenerate();
            return redirect()->to('/member/');
        }

        session()->flash('error', 'Nomor WhatsApp atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.member-login')->layout('layouts.public');
    }
}