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

        if ($this->method === 'qris' && !empty($this->paymentCode)) {
            $this->qrUrl = 'data:image/svg+xml;base64,' . base64_encode(
                QrCode::format('svg')->size(300)->errorCorrection('H')->generate($this->paymentCode)
            );
        }

        if ($order && $order->status === 'paid') {
            $member = Member::where('whatsapp', $order->customer_whatsapp)->first();
            if ($member && !Auth::guard('member')->check()) {
                Auth::guard('member')->login($member);
            }
        }
    }

    public function processPayment(DokuService $dokuService, $order)
    {
        $eWallets = ['dana', 'shopeepay'];

        if (in_array($this->method, $eWallets)) {
            $response = $dokuService->createEwallet($order, $this->method);

            $data = $response->json();

            $order->update(['payment_code' => $data['webRedirectUrl']]);

            return redirect()->away($data['webRedirectUrl']);

        } elseif ($this->method === 'qris') {
            $response = $dokuService->createQRIS($order);
        } else {
            $response = $dokuService->createVA($order);
        }
        if ($response && $response->successful()) {
            $data = $response->json();
            $code = null;

            if ($this->method === 'qris') {
                $code = $data['qrContent'] ?? null;
            } else {    
                $code = $data['virtualAccountData']['virtualAccountNo'] ?? null;
            }

            if ($code) {
                $this->paymentCode = trim($code);
                $order->update(['payment_code' => $this->paymentCode]);
                return true;
            }
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