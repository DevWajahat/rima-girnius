<div class="container-fluid p-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Orders</h2>
            <p class="text-muted mb-0">View and manage customer transactions.</p>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            {{-- Search Bar --}}
            <div class="row g-3 mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0 bg-light"
                               placeholder="Search Order ID, Name, Email..."
                               wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('id')" style="cursor: pointer;">
                                ID <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold">
                                Customer
                            </th>
                             <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold">
                                 customer_id
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold">
                                Item
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('transaction_id')" style="cursor: pointer;">
                                Transaction ID <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('status')" style="cursor: pointer;">
                                Status <i class="fas fa-sort ms-1"></i>
                            </th>
                            <th class="py-3 border-bottom-0 text-uppercase text-secondary small fw-bold" wire:click="sortBy('created_at')" style="cursor: pointer;">
                                Date <i class="fas fa-sort ms-1"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr wire:key="order-{{ $order->id }}">
                                <td class="ps-3 fw-bold text-muted">#{{ $order->id }}</td>

                                {{-- Customer Info --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">
                                            {{ $order->user->first_name }} {{$order->user->last_name }}
                                        </span>
                                        <small class="text-muted">{{ optional($order->user)->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    {{ $order->user_id }}
                                </td>

                             <td class="">
                                    {{ $order->book->title }}
                                </td>



                                    {{-- Transaction ID --}}
                                <td>
                                    <span class="font-monospace text-dark">{{ $order->transaction_id }}</span>
                                </td>

                                {{-- Status Badge --}}
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge bg-success bg-opacity-10 text-white px-3 py-2 rounded-pill">
                                            Completed
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-white px-3 py-2 rounded-pill">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Date --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $order->created_at->format('M d, Y') }}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>

                                {{-- Actions --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-5">
                                        <div class="mb-3">
                                            <i class="fas fa-shopping-bag fa-3x text-light"></i>
                                        </div>
                                        <h5 class="text-secondary">No orders found</h5>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-end">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
