<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;

class Checkout extends Component
{
    public $cart = [];
    public $totalPrice = 0;

    public $name;
    public $whatsapp;
    public $address;
    public $payment_method;

    protected $rules = [
        'name' => 'required|min:3',
        'whatsapp' => 'required|numeric|digits_between:10,15',
        'address' => 'required|min:10',
        'payment_method' => 'required|in:qris,alfamart,indomaret,cod',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'name.min' => 'Nama lengkap minimal 3 karakter.',
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

        // --- PROTEKSI BACK-END: QUERY ULANG PRODUK & HITUNG ULANG HARGA ASLI ---
        $serverTotalPrice = 0;
        $secureCart = [];

        foreach ($this->cart as $item) {
            // Ambil data produk asli langsung dari database berdasarkan ID
            $product = Product::find($item['product_id']);

            // Jika produk tiba-tiba tidak ditemukan di DB
            if (!$product) {
                session()->flash('error', "Produk {$item['name']} sudah tidak tersedia.");
                return redirect()->to('/cart');
            }

            // Hitung subtotal menggunakan harga asli dari database, BUKAN dari properti Livewire
            $serverTotalPrice += $product->price * $item['qty'];

            // Susun ulang struktur cart yang aman untuk snapshot database
            $secureCart[] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'qty'        => $item['qty'],
                'price'      => $product->price, // Menggunakan harga resmi DB
            ];
        }
        // ----------------------------------------------------------------------

        $orderId = 'INV-' . time();
        Order::create([
            'order_id'          => $orderId,
            'customer_name'     => $this->name,
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