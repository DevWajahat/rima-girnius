@extends('layouts.admin.app')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            {{-- Today Orders --}}
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Orders</p>
                        <h6 class="mb-0">{{ $todaySalesCount }}</h6>
                    </div>
                </div>
            </div>

            {{-- Total Orders --}}
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Orders</p>
                        <h6 class="mb-0">{{ $totalSalesCount }}</h6>
                    </div>
                </div>
            </div>

            {{-- Today Revenue --}}
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Revenue</p>
                        <h6 class="mb-0">${{ number_format($todayRevenue, 2) }}</h6>
                    </div>
                </div>
            </div>

            {{-- Total Revenue --}}
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Revenue</p>
                        <h6 class="mb-0">${{ number_format($totalRevenue, 2) }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">

            {{-- Top Selling Books --}}
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light text-center rounded p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Top Selling Books</h6>
                        <a href="{{ route('books') }}" target="_blank">View Store</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Book Title</th>
                                    <th scope="col" class="text-end">Price</th>
                                    <th scope="col" class="text-center">Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topBooks as $stat)
                                    <tr>
                                        <td>{{ $stat->book->title ?? 'Unknown Book' }}</td>
                                        <td class="text-end">
                                            ${{ number_format($stat->book->sale_price ?? $stat->book->price, 2) }}
                                        </td>
                                        <td class="text-center fw-bold">{{ $stat->sales_count }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">No sales data yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- New Customers --}}
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">New Customers</h6>
                        {{-- Link to Users page if you have one, or remove --}}
                        <a href="#">Show All</a>
                    </div>
                    @forelse($newUsers as $user)
                        <div class="d-flex align-items-center border-bottom py-3">
                            <div class="bg-success rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 40px; height: 40px;">
                                {{ substr($user->first_name, 0, 1) }}
                            </div>
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                    <small>{{ $user->created_at->format('d M') }}</small>
                                </div>
                                <span class="text-muted small">{{ $user->email }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No users found.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Recent Orders</h6>
                <a href="{{ route('admin.orders') }}">Show All</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Date</th>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Book</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ $order->transaction_id }}</td>
                                <td>{{ optional($order->user)->first_name }}</td>
                                <td>{{ optional($order->book)->title ?? 'Unknown' }}</td>
                                <td>
                                    ${{ number_format(optional($order->book)->sale_price ?? optional($order->book)->price, 2) }}
                                </td>
                                <td>
                                    @if($order->status == 'completed')
                                        <span class="text-success">Paid</span>
                                    @else
                                        {{ ucfirst($order->status) }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No recent orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            {{-- Recent Inquiries --}}
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0">Recent Inquiries</h6>
                        <a href="{{ route('admin.contacts.index') }}">Show All</a>
                    </div>
                    @forelse($recentMessages as $msg)
                        <div class="d-flex align-items-center border-bottom py-3">
                            <div class="bg-primary rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 40px; height: 40px;">
                                {{ substr($msg->name, 0, 1) }}
                            </div>
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">{{ $msg->name }}</h6>
                                    <small>{{ $msg->created_at->diffForHumans() }}</small>
                                </div>
                                <span class="text-muted small text-truncate d-block" style="max-width: 200px;">
                                    {{ $msg->subject }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No new messages.</div>
                    @endforelse
                </div>
            </div>

            {{-- Calendar --}}
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Calendar</h6>
                    </div>
                    <div id="calender"></div>
                </div>
            </div>

            {{-- To Do List --}}
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">To Do List</h6>
                    </div>
                    <div class="d-flex mb-2">
                        <input class="form-control bg-transparent" type="text" placeholder="Enter task">
                        <button type="button" class="btn btn-primary ms-2">Add</button>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-2">
                        <input class="form-check-input m-0" type="checkbox">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span>Check new orders</span>
                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
