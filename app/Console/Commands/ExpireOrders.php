<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class ExpireOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-orders';

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
        $count = Order::where('status', 'pending')
            ->where('created_at', '<=', now()->subMinutes(15))
            ->update([
                'status' => 'failed'
            ]);

        $this->info("Total expired: {$count}");
    }
}
