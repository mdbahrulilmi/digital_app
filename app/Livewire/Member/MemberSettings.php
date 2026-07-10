<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MemberSettings extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:8|same:new_password_confirmation',
    ];

    public function updatePassword()
    {
        $this->validate();

        $member = Auth::guard('member')->user();

        if (!Hash::check($this->current_password, $member->password)) {
            $this->addError('current_password', 'Kata sandi saat ini salah.');
            return;
        }

        $member->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('message', 'Kata sandi berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.member.member-settings')->layout('layouts.member');
    }
}