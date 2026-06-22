<?php

namespace App\Livewire\Auth;

use App\Models\Member;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class MemberRegister extends Component
{
    public $name;
    public $whatsapp;
    public $password;
    public $email;
    public $address;

    protected $rules = [
        'name' => 'required|min:3',
        'whatsapp' => 'required|numeric|unique:members,whatsapp',
        'password' => 'required|min:8',
        'email' => 'nullable|email|unique:members,email',
        'address' => 'nullable|string',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'name.min' => 'Nama minimal 3 karakter.',
        'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        'whatsapp.numeric' => 'Format nomor WhatsApp harus angka.',
        'whatsapp.unique' => 'Nomor WhatsApp sudah terdaftar.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah digunakan.',
    ];

    public function register()
    {
        $validatedData = $this->validate();
        $validatedData['password'] = Hash::make($this->password);

        Member::create($validatedData);

        session()->flash('message', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login'); 
    }

    public function render()
    {
        return view('livewire.auth.member-register')->layout('layouts.public');
    }
}
