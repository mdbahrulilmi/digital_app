<?php

namespace App\Livewire\Admin\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class OrderList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = Order::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('order_id', 'like', "%{$this->search}%")
                        ->orWhere('customer_name', 'like', "%{$this->search}%")
                        ->orWhere('customer_whatsapp', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status != '', function ($q) {
                $q->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.order.list', [
            'orders' => $orders
        ]);
    }
}