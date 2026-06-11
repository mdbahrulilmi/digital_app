<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // WAJIB PAKAI INI
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    // Sembunyikan password saat data di-serialize
    protected $hidden = [
        'password',
    ];
}