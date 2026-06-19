<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        $revenue = Order::whereMonth('created_at', date('m'))
                        ->where('status', 'success')
                        ->sum('amount');

        $totalSold = DB::table('order_items')
                       ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
                       ->where('orders.status', 'success')
                       ->sum('qty');

        $chartData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
                          ->where('created_at', '>=', now()->subDays(7))
                          ->groupBy('date')
                          ->pluck('total', 'date');

        $bestSellingProducts = OrderItem::select('name', \DB::raw('SUM(qty) as total_sold'))
        ->whereHas('order', function($query) {
            $query->where('status', 'success');
        })
        ->groupBy('name')
        ->orderBy('total_sold', 'desc')
        ->limit(5)
        ->get();

        $maxSold = $bestSellingProducts->max('total_sold') ?: 1;

        $activeVisitors = Visitor::where('last_visit', '>=', now()->subMinutes(10))
        ->count();

        $totalSuccessOrders = Order::where('status', 'success')->count();
        
        $visitors = Visitor::all();
        $totalVisitors = $visitors->count();
        
        $conversionRate = ($totalVisitors > 0) ? ($totalSuccessOrders / $totalVisitors) * 100 : 0;
        $trafficData = $visitors->groupBy(function($visitor) {
            if (is_null($visitor->referrer)) return 'Direct / Refresh';
            if (str_contains($visitor->referrer, 'google')) return 'Organic Search';
            if (str_contains($visitor->referrer, 'instagram') || str_contains($visitor->referrer, 'facebook')) return 'Social Media';
            return 'Others';
        });

        $deviceData = $visitors->groupBy(function($visitor) {
            $ua = strtolower($visitor->user_agent);
            if (str_contains($ua, 'mobile')) return 'Mobile';
            if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) return 'Tablet';
            return 'Desktop';
        });

        return view('livewire.admin.dashboard', [
            'revenue' => $revenue,
            'totalSold' => $totalSold,
            'chartData' => $chartData,
            'activeVisitors' => $activeVisitors,
            'trafficData' => $trafficData,
            'totalVisitors' => $totalVisitors,
            'conversionRate' => number_format($conversionRate, 1),
            'deviceData' => $deviceData,
            'bestSellingProducts' => $bestSellingProducts,
            'maxSold' => $maxSold
        ]);
    }
}