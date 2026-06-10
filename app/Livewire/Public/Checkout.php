<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Checkout extends Component
{
    public $cart = [];
    public $totalPrice = 0;

    // Properti untuk Form Data Pembeli
    public $name;
    public $whatsapp;
    public $address;
    public $payment_method;

    // Aturan Validasi Form
    protected $rules = [
        'name' => 'required|min:3',
        'whatsapp' => 'required|numeric|min:10',
        'address' => 'required|min:10',
        'payment_method' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        'whatsapp.numeric' => 'Nomor WhatsApp harus berupa angka.',
        'address.required' => 'Alamat pengiriman lengkap wajib diisi.',
        'payment_method.required' => 'Silakan pilih metode pembayaran.',
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        
        // Jika keranjang kosong, kembalikan ke halaman depan atau cart
        if (count($this->cart) === 0) {
            return redirect()->to('/cart');
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalPrice = 0;
        foreach ($this->cart as $item) {
            $this->totalPrice += $item['price'] * $item['qty'];
        }
    }

    public function processOrder()
    {
        // Jalankan Validasi Form
        $this->validate();

        // 1. SIMPAN KE DATABASE (Opsional - Jika kamu punya tabel Orders)
        // $order = Order::create([...]);

        // 2. CONTOH REDIRECT KIRIM DATA KE WHATSAPP (Paling sering dipakai untuk Landing Page)
        $message = "Halo, saya mau pesan produk berikut:\n\n";
        foreach ($this->cart as $item) {
            $message .= "- " . $item['name'] . " (x" . $item['qty'] . ") : Rp " . number_format($item['price'] * $item['qty'], 0, ',', '.') . "\n";
        }
        $message .= "\n*Total Pembayaran:* Rp " . number_format($this->totalPrice, 0, ',', '.') . "\n";
        $message .= "*Metode Pembayaran:* " . strtoupper($this->payment_method) . "\n\n";
        $message .= "*Data Pengiriman:*\n";
        $message .= "Nama: " . $this->name . "\n";
        $message .= "WhatsApp: " . $this->whatsapp . "\n";
        $message .= "Alamat: " . $this->address;

        // Kosongkan keranjang setelah order berhasil diproses
        session()->forget('cart');

        // Ganti nomor di bawah dengan nomor WhatsApp admin tokomu
        $adminWhatsapp = "6281234567890"; 
        $url = "https://api.whatsapp.com/send?phone=" . $adminWhatsapp . "&text=" . urlencode($message);

        return redirect()->away($url);
    }

    public function render()
    {
        return view('livewire.public.checkout')
            ->layout('layouts.public');
    }
}