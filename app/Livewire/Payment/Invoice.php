<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Member;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\DokuService;

class Invoice extends Component
{
    public $orderId, $method, $amount, $paymentStatus;
    public $qrUrl, $paymentCode;

    public function mount(DokuService $dokuService)
    {
        $this->orderId = request()->query('order_id');
        $this->method = request()->query('method');
        
        $order = Order::where('order_id', $this->orderId)->firstOrFail();
        
        $this->amount = $order->amount;
        $this->paymentStatus = $order->status;
        
        $this->paymentCode = $order->payment_code; 
        
        if (empty($order->payment_code) && $this->paymentStatus === 'pending') {
            $this->processPayment($dokuService, $order);
        }
    }

    public function processPayment(DokuService $dokuService, $order)
    {
        $response = ($this->method === 'qris')
        ? $dokuService->createQRIS($order)
        : $dokuService->createVA($order);

        if ($response->successful()) {
            $paymentCode = $response->json('virtualAccountData.virtualAccountNo');
            
            $this->paymentCode = trim($paymentCode);
            
            $order->update([
                'payment_code' => $this->paymentCode,
            ]);
            
            return true;
        }
        return false;
    }
    
    public function checkPaymentStatus()
    {
        $order = Order::where('order_id', $this->orderId)->first();
        
        if ($order) {
            $this->paymentStatus = $order->status;
            if ($this->paymentStatus === 'paid') {
                session()->flash('message', 'Pembayaran berhasil!');
                return redirect()->route('payment.success', [
                'order_id' => $this->orderId
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.payment.invoice')->layout('layouts.public');
    }
}