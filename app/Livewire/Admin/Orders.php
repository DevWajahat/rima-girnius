<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class Orders extends Component
{
    use WithPagination;

    // Defines the default layout (Livewire will find components.layouts.app by default)
    // If you have a specific admin layout, uncomment the line below:
    // protected $layout = 'layouts.admin';

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        // Optional: Add delete logic if you want admins to delete orders
        Order::find($id)->delete();
        session()->flash('message', 'Order deleted successfully.');
    }

    public function render()
    {
        $orders = Order::with('user')
            ->where('transaction_id', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.orders', [
            'orders' => $orders
        ]);
    }
}
