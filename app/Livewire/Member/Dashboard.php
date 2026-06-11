<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Ambil nomor whatsapp member yang sedang login lewat guard 'member'
        $memberWhatsapp = Auth::guard('member')->user()->whatsapp;

        // 2. Tarik semua data orderan milik member ini beserta daftar produk di dalamnya
        $orders = Order::with('items')
            ->where('customer_whatsapp', $memberWhatsapp)
            ->latest()
            ->get();

        return view('livewire.member.dashboard', [
            'orders' => $orders
        ])->layout('layouts.member'); // 👈 Sesuaikan dengan nama file layout member area Anda
    }
}