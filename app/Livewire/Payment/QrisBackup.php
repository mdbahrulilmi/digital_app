<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use Midtrans\Config;
use Midtrans\CoreApi; // Ubah ke CoreApi

class Qris extends Component
{
    public $qrUrl; // Simpan URL gambar QR Code
    public $orderId;

    public function generateQr()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->orderId = 'INV-' . time();

        $params = [
            'payment_type' => 'qris', // Wajib di Core API
            'transaction_details' => [
                'order_id' => $this->orderId,
                'gross_amount' => 10000,
            ],
            'qris' => [
                'acquirer' => 'gopay' // Contoh acquirer provider QRIS
            ]
        ];

        try {
            // Menggunakan CoreApi::charge
            $response = CoreApi::charge($params);
            
            // Ambil URL QR Code dari response actions
            if (isset($response->actions)) {
                foreach ($response->actions as $action) {
                    if ($action->name == 'generate-qr-code') {
                        $this->qrUrl = $action->url; // Ini URL gambar QR Code-nya
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.payment.qris')->layout('layouts.public');
    }
}