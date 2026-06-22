<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Program;
use Illuminate\Database\Seeder;

class MemberDebugSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Member Debug
        $member = Member::updateOrCreate(
            ['email' => 'debug@example.com'],
            [
                'name' => 'User Debug',
                'whatsapp' => '12345678',
                'address' => 'Lab Development, Jakarta',
                'password' => bcrypt('12345678'),
            ]
        );

        // 2. Data Program Debug
        $program = Program::updateOrCreate(
            ['slug' => 'program-debug'],
            [
                'title' => 'Program Testing',
                'price' => 50000,
                'status' => 'active',
            ]
        );

        // 3. Data Order Debug
        $order = Order::updateOrCreate(
            ['order_id' => 'DEBUG-001'],
            [
                'customer_name' => $member->name,
                'customer_email' => $member->email,
                'customer_whatsapp' => $member->whatsapp,
                'customer_address' => $member->address,
                'amount' => 50000,
                'payment_method' => 'Manual Transfer',
                'status' => 'pending',
            ]
        );

        // 4. Data Order Item Debug
        OrderItem::updateOrCreate(
            ['order_id' => 'DEBUG-001'],
            [
                'program_id' => $program->id,
                'type' => 'program',
                'name' => $program->title,
                'qty' => 1,
                'price' => 50000,
            ]
        );
    }
}