<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use Midtrans\Config;
use Midtrans\CoreApi;
use App\Models\Order;

class Invoice extends Component
{
    public $qrUrl; 
    public $paymentCode; 
    public $orderId;
    public $method;
    public $amount;
    public $paymentStatus = 'Waiting for Payment';

    public function mount()
    {
        $this->orderId = request()->query('order_id');
        $this->method = request()->query('method');

        $order = Order::where('order_id', $this->orderId)->first();

        if (!$order) {
            abort(404, 'Invoice tidak ditemukan.');
        }

        $this->amount = $order->amount;
        $this->paymentStatus = $order->status; // Ambil status awal dari DB

        // Hanya minta charge ke Midtrans jika statusnya masih baru/pending
        if ($this->paymentStatus === 'pending' || $this->paymentStatus === 'Waiting for Payment') {
            $this->requestMidtransCharge();
        }
    }

    public function checkPaymentStatus()
    {
        $order = Order::where('order_id', $this->orderId)->first();

        if ($order) {
            $this->paymentStatus = $order->status;

            if ($order->status === 'success' || $order->status === 'settlement') {
                
                $member = Member::where('whatsapp', $order->customer_whatsapp)->first();
                if (!$member) {
                    $member = Member::create([
                        'name'     => $order->customer_name,
                        'whatsapp' => $order->customer_whatsapp,
                        'address'  => $order->customer_address,
                        'password' => Hash::make($order->customer_whatsapp),
                    ]);
                }

                Auth::guard('member')->login($member);

                $checkItems = OrderItem::where('order_id', $order->order_id)->exists();
                
                if (!$checkItems && $order->cart_snapshot) {
                    $cartData = json_decode($order->cart_snapshot, true);

                    foreach ($cartData as $item) {
                        OrderItem::create([
                            'order_id'     => $order->order_id,
                            'product_id'   => $item['product_id'],
                            'product_name' => $item['name'],
                            'qty'          => $item['qty'],
                            'price'        => $item['price'],
                        ]);

                        $product = Product::find($item['product_id']);
                        if ($product) {
                            $product->decrement('stock', $item['qty']);
                        }
                    }
                }

                session()->forget('cart');

                // 4. REDIRECT INSTAN KE MEMBER AREA
                session()->flash('message', 'Pembayaran Berhasil! Selamat datang di Member Area.');
                return redirect()->to('/member/dashboard');
            }
        }
    }

    private function requestMidtransCharge()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $this->orderId,
                'gross_amount' => $this->amount,
            ],
        ];

        if ($this->method === 'qris') {
            $params['payment_type'] = 'qris';
            $params['qris'] = ['acquirer' => 'gopay'];
        } elseif ($this->method === 'alfamart') {
            $params['payment_type'] = 'cstore';
            $params['cstore'] = ['store' => 'alfamart'];
        } elseif ($this->method === 'indomaret') {
            $params['payment_type'] = 'indomaret';
            $params['cstore'] = ['store' => 'indomaret'];
        }

        try {
            $response = CoreApi::charge($params);
            
            if ($this->method === 'qris') {
                if (isset($response->actions)) {
                    foreach ($response->actions as $action) {
                        if ($action->name == 'generate-qr-code') {
                            $this->qrUrl = $action->url;
                            break;
                        }
                    }
                }
            } else {
                $this->paymentCode = $response->payment_code ?? null;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Koneksi Payment Gateway Gagal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.payment.invoice')->layout('layouts.public');
    }
}