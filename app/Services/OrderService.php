<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Member;
use App\Models\MemberProduct;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;

class OrderService
{
    public function processSuccessPayment(Order $order)
    {
        if ($order->items()->exists()) return;

        $member = Member::firstOrCreate(
            ['whatsapp' => $order->customer_whatsapp],
            [
                'name' => $order->customer_name,
                'email' => $order->customer_email,
                'password' => Hash::make($order->customer_whatsapp),
            ]
        );

        $cartData = json_decode($order->cart_snapshot, true) ?? [];

        foreach ($cartData as $item) {

            $isProduct = $item['type'] === 'product';

            $order->items()->create([
                'type'       => $item['type'],
                'product_id' => $isProduct ? $item['id'] : null,
                'program_id' => !$isProduct ? $item['id'] : null,
                'name'       => $item['name'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
            ]);

            if ($item['type'] === 'program') {
                Enrollment::firstOrCreate(
                    [
                        'member_id' => $member->id,
                        'program_id' => $item['id'],
                    ],
                    [
                        'order_id' => $order->order_id,
                        'status_enroll' => 'active',
                    ]
                );
            } else{
                MemberProduct::firstOrCreate(
                    [
                        'member_id' => $member->id,
                        'product_id' => $item['id'],
                    ],
                    [
                        'order_id' => $order->order_id,
                    ]
                );
            }
        }
    }
}