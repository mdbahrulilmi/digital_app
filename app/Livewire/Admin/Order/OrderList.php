<?php

namespace App\Livewire\Admin\Order;

use Livewire\Component;
use Livewire\WithPagination; // Tambahkan ini
use App\Models\Order;

class OrderList extends Component
{
    use WithPagination; // Tambahkan ini untuk pagination

    public $search = ''; // Properti untuk menampung input pencarian

    // Reset pagination ketika user mengetik
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = Order::query()
            ->where('order_id', 'like', '%' . $this->search . '%')
            ->orWhere('customer_name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.order.list', [
            'orders' => $orders
        ]);
    }
}