<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItem;
use App\Models\Member;
use App\Models\MemberProduct;

class SyncMemberProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-member-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        $items = OrderItem::with('order')
            ->where('type', 'product')
            ->get();

        foreach ($items as $item) {

            if (!$item->order) {
                continue;
            }

            $member = Member::firstOrCreate(
                [
                    'whatsapp' => $item->order->customer_whatsapp,
                ],
                [
                    'name' => $item->order->customer_name,
                    'email' => $item->order->customer_email,
                    'address' => $item->order->customer_address,
                    'password' => bcrypt($item->order->customer_whatsapp),
                ]
            );

            if (!$item->order->member_id) {
                $item->order->update([
                    'member_id' => $member->id,
                ]);
            }

            MemberProduct::firstOrCreate(
                [
                    'member_id' => $member->id,
                    'product_id' => $item->product_id,
                ],
                [
                    'order_id' => $item->order->order_id,
                ]
            );
        }

        $this->info('Member products berhasil disinkronkan.');
    }
}
