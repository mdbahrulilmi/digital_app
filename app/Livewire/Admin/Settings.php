<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Settings extends Component
{
    public $app_name;
    public $email_admin;

    public function mount()
    {
    }

    public function save()
    {
        session()->flash('message', 'Pengaturan berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}