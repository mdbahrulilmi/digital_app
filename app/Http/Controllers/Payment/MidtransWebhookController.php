<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Member;       // 👈 1. Import Model Member
use App\Models\OrderItem;    // 👈 2. Import Model OrderItem
use App\Models\Product;      // 👈 3. Import Model Product
use Illuminate\Support\Facades\Hash;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handleNotification(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; 
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $notif = new Notification();

            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;
            $paymentType = $notif->payment_type;
            $fraudStatus = $notif->fraud_status;

            $order = Order::where('order_id', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            $isPaymentSuccess = false;

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $order->update(['status' => 'challenge']);
                    } else {
                        $order->update(['status' => 'success']);
                        $isPaymentSuccess = true; // 👈 CC Sukses
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->update(['status' => 'success']);
                $isPaymentSuccess = true; // 👈 QRIS / Retail / E-Wallet Sukses
            } elseif ($transactionStatus == 'pending') {
                $order->update(['status' => 'pending']);
            } elseif ($transactionStatus == 'deny') {
                $order->update(['status' => 'denied']);
            } elseif ($transactionStatus == 'expire') {
                $order->update(['status' => 'expired']);
            } elseif ($transactionStatus == 'cancel') {
                $order->update(['status' => 'cancelled']);
            }

            // 5. JIKA PEMBAYARAN SUKSES -> PROSES MEMBER, ORDER ITEMS, & POTONG STOK
            if ($isPaymentSuccess) {
                
                // A. Pembuatan / Pengambilan Akun Member
                $member = Member::where('whatsapp', $order->customer_whatsapp)->first();
                if (!$member) {
                    $member = Member::create([
                        'name'     => $order->customer_name,
                        'whatsapp' => $order->customer_whatsapp,
                        'address'  => $order->customer_address,
                        'password' => Hash::make($order->customer_whatsapp), // Password default nomor WA
                    ]);
                }

                // B. Pindahkan data dari cart_snapshot ke tabel order_items (Hanya jika belum pernah diisi)
                $checkItems = OrderItem::where('order_id', $order->order_id)->exists();
                
                if (!$checkItems && $order->cart_snapshot) {
                    $cartData = json_decode($order->cart_snapshot, true);

                    foreach ($cartData as $item) {
                        // Simpan ke detail item pesanan
                        OrderItem::create([
                            'order_id'     => $order->order_id,
                            'product_id'   => $item['product_id'],
                            'product_name' => $item['name'],
                            'qty'          => $item['qty'],
                            'price'        => $item['price'],
                        ]);

                        // C. KONTROL STOK: Potong stok produk di database asli
                        $product = Product::find($item['product_id']);
                        if ($product) {
                            // Gunakan decrement agar aman dari race condition database
                            $product->decrement('stock', $item['qty']);
                        }
                    }
                }
            }

            return response()->json(['message' => 'Webhook berhasil diproses'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada webhook',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}