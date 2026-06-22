<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\Program;

class Checkout extends Component
{
    public $cart = [];
    public $totalPrice = 0;

    public $name;
    public $email;
    public $whatsapp;
    public $address;
    public $payment_method;

    public $password;
    public $password_confirmation;

    public $paymentGroups;

    

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'whatsapp' => 'required|numeric|digits_between:10,15',
        'address' => 'required|min:10',
        'payment_method' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'name.min' => 'Nama lengkap minimal 3 karakter.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        'whatsapp.numeric' => 'Nomor WhatsApp harus berupa angka.',
        'whatsapp.digits_between' => 'Nomor WhatsApp harus di antara 10 sampai 15 digit.',
        'address.required' => 'Alamat pengiriman lengkap wajib diisi.',
        'address.min' => 'Alamat pengiriman minimal 10 karakter.',
        'payment_method.required' => 'Silakan pilih metode pembayaran.',
        'payment_method.in' => 'Metode pembayaran tidak valid.',
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);

        $this->paymentGroups = [
            // 'E-Wallet & QRIS' => [
            //     'qris'      => ['label' => 'QRIS', 'icon' => asset('assets_content/icon/payment/qris.svg')],
            //     'ovo'       => ['label' => 'OVO', 'icon' => asset('assets_content/icon/payment/ovo.svg')],
            //     'shopeepay' => ['label' => 'ShopeePay', 'icon' => asset('assets_content/icon/payment/shopee.svg')],
            //     'dana'      => ['label' => 'DANA', 'icon' => asset('assets_content/icon/payment/dana.svg')],
            // ],
            'Virtual Account (SNAP)' => [
                'va_bca'    => ['label' => 'BCA', 'icon' => asset('assets_content/icon/payment/bca.svg')],
                'va_mandiri'=> ['label' => 'Mandiri', 'icon' => asset('assets_content/icon/payment/mandiri.svg')],
                'va_bni'    => ['label' => 'BNI', 'icon' => asset('assets_content/icon/payment/bni.svg')],
                'va_bri'    => ['label' => 'BRI', 'icon' => asset('assets_content/icon/payment/bri.svg')],
                'va_cimb'   => ['label' => 'CIMB Niaga', 'icon' => asset('assets_content/icon/payment/qris.svg')],
                'va_bsi'    => ['label' => 'BSI', 'icon' => asset('assets_content/icon/payment/qris.svg')],
            ],
            // 'Retail & Paylater' => [
            //     'alfamart'  => ['label' => 'Alfamart', 'icon' => asset('assets_content/icon/payment/alfamart.svg')],
            //     'indomaret' => ['label' => 'Indomaret', 'icon' => asset('assets_content/icon/payment/indomaret.svg')],
            // ]
        ];
        
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
        $this->validate();
        $serverTotalPrice = 0;
        $secureCart = [];

        foreach ($this->cart as $item) {
            if ($item['type'] === 'product') {
                $data = Product::find($item['id']);
            } else {
                $data = Program::find($item['id']);
            }

            if (!$data) {
                session()->flash('error', "Produk/Program {$item['name']} sudah tidak tersedia.");
                return redirect()->to('/cart');
            }

            $serverTotalPrice += $data->price * $item['qty'];

            $secureCart[] = [
                'id'    => $data->id,
                'name'  => $data->title,
                'qty'   => $item['qty'],
                'price' => $data->price,
                'type'  => $item['type'],
            ];
        }

        $orderId = 'INV-' . time();
        Order::create([
            'order_id'          => $orderId,
            'customer_name'     => $this->name,
            'customer_email'     => $this->email,
            'customer_whatsapp' => $this->whatsapp,
            'customer_address'  => $this->address,
            'amount'            => $serverTotalPrice,
            'payment_method'    => $this->payment_method,
            'cart_snapshot'     => json_encode($secureCart),
            'status'            => 'pending',
        ]);

        session()->forget('cart');

        return redirect()->to(route('payment.invoice', [
            'order_id' => $orderId,
            'method'   => $this->payment_method
        ]));
    }
    public function render()
    {
        return view('livewire.public.checkout')
            ->layout('layouts.public');
    }
}