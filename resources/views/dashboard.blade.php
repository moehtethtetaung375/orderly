
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- Dashboard Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#25213b;">
                Welcome back, {{ auth()->user()->name }}!
            </h2>

            <p class="text-secondary mb-0">
                Here's what's happening with your orders today.
            </p>
        </div>

        <div class="text-secondary small">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->format('d M Y') }}
        </div>
    </div>


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total Items --}}
        <div class="col-sm-6 col-xl-4">
            <div class="content-card p-4 h-100"
                 style="border:1px solid #eee8f8; border-radius:16px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-secondary small fw-semibold mb-2">
                            TOTAL ITEMS
                        </p>

                        <h2 class="fw-bold mb-1" style="color:#25213b;">
                            {{ number_format($totalItems) }}
                        </h2>

                        <span class="text-secondary small">
                            Available in catalog
                        </span>
                    </div>

                    <div class="rounded-3 p-3"
                         style="background:#f0e8ff;color:#7138e5;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>

                <a href="{{ route('items.index') }}"
                   class="small fw-semibold text-decoration-none d-inline-block mt-3"
                   style="color:#7138e5;">
                    Browse items <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>


        {{-- My Total Orders --}}
        <div class="col-sm-6 col-xl-4">
            <div class="content-card p-4 h-100"
                 style="border:1px solid #eee8f8; border-radius:16px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        {{-- Total Orders --}}
                        <p class="text-secondary small fw-semibold mb-2">
                            {{ $isAdmin ? 'TOTAL ORDERS' : 'MY TOTAL ORDERS' }}
                        </p>

                        <h2 class="fw-bold mb-1" style="color:#25213b;">
                            {{ number_format($totalOrders) }}
                        </h2>

                        <span class="text-secondary small">
                            {{ $isAdmin ? 'Orders created by all users' : 'Orders created by you' }}
                        </span>
                    </div>

                    <div class="rounded-3 p-3"
                         style="background:#e8f6ff;color:#1478b8;">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>
                </div>

                <a href="{{ route('orders.index') }}"
                   class="small fw-semibold text-decoration-none d-inline-block mt-3"
                   style="color:#1478b8;">
                    Browse orders <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>


        {{-- Low Stock Count --}}
        <div class="col-sm-6 col-xl-4">
            <div class="content-card p-4 h-100"
                 style="border:1px solid #eee8f8; border-radius:16px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-secondary small fw-semibold mb-2">
                            LOW STOCK ITEMS
                        </p>

                        <h2 class="fw-bold mb-1" style="color:#25213b;">
                            {{ number_format($lowStockCount) }}
                        </h2>

                        <span class="text-secondary small">
                            Items with stock of 5 or less
                        </span>
                    </div>

                    <div class="rounded-3 p-3"
                         style="background:#fff0e8;color:#e47b35;">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                </div>

                <a href="{{ route('items.index') }}"
                   class="small fw-semibold text-decoration-none d-inline-block mt-3"
                   style="color:#e47b35;">
                    Check inventory <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

    </div>


    {{-- Recent Orders and Order Status Overview --}}
    <div class="row g-4 mb-4">

        {{-- Recent Orders --}}
        <div class="col-xl-7">
            <div class="content-card p-4 h-100"
                 style="border:1px solid #eee8f8; border-radius:16px;">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1" style="color:#25213b;">
                            Recent Orders
                        </h5>

                        {{-- Recent Orders Description --}}
                        <p class="text-secondary small mb-0">
                            {{ $isAdmin ? 'Latest orders from all users' : 'Your latest order activity' }}
                        </p>
                    </div>

                    <a href="{{ route('orders.index') }}"
                       class="small fw-semibold text-decoration-none"
                       style="color:#7138e5;">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @if($recentOrders->isEmpty())
                    <div class="text-center py-5">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width:60px;height:60px;background:#f0e8ff;color:#7138e5;">
                            <i class="bi bi-receipt fs-3"></i>
                        </div>

                        <h6 class="fw-semibold">No orders yet</h6>

                        <p class="text-secondary small mb-0">
                            Your recent orders will appear here.
                        </p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">

                            <thead>
                                <tr class="small text-secondary">
                                    <th class="fw-semibold border-0">ORDER</th>

                                    {{-- Show User Name for Admin Only --}}
                                    @if ($isAdmin)
                                        <th class="fw-semibold border-0">USER</th>
                                    @endif

                                    <th class="fw-semibold border-0">DATE</th>
                                    <th class="fw-semibold border-0">STATUS</th>
                                    <th class="fw-semibold border-0 text-end">TOTAL</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($recentOrders as $order)
                                    @php
                                        $statusStyles = [
                                            'pending' => 'background:#fff4dc;color:#bd8419;',
                                            'processing' => 'background:#e8f3ff;color:#2878c7;',
                                            'completed' => 'background:#e5f7ed;color:#218653;',
                                            'cancelled' => 'background:#ffe9eb;color:#c64c59;',
                                        ];
                                    @endphp

                                    <tr>
                                        {{-- Order ID --}}
                                        <td class="fw-semibold">
                                            <a href="{{ route('orders.show', $order->id) }}"
                                            class="text-decoration-none"
                                            style="color:#7138e5;">
                                                #{{ $order->id }}
                                            </a>
                                        </td>

                                        {{-- User Name - Admin Only --}}
                                        @if ($isAdmin)
                                            <td class="fw-semibold small">
                                                {{ $order->user->name ?? 'Unknown User' }}
                                            </td>
                                        @endif

                                        {{-- Order Date --}}
                                        <td class="text-secondary small">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill px-3 py-2"
                                                  style="{{ $statusStyles[$order->status] ?? 'background:#eeeeee;color:#555;' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        <td class="text-end fw-semibold small">
                                            {{ number_format($order->total_amount, 2) }} MMK
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                @endif

            </div>
        </div>


        {{-- Order Status Overview --}}
        <div class="col-xl-5">
            <div class="content-card p-4 h-100"
                 style="border:1px solid #eee8f8; border-radius:16px;">

                <div class="mb-4">
                    <h5 class="fw-bold mb-1" style="color:#25213b;">
                        Order Status Overview
                    </h5>

                    {{-- Order Status Description --}}
                    <p class="text-secondary small mb-0">
                        {{ $isAdmin ? 'Order status breakdown from all users' : 'Breakdown of your order statuses' }}
                    </p>
                </div>

                @php
                    $statusDetails = [
                        [
                            'name' => 'Pending',
                            'count' => $pendingOrders,
                            'color' => '#d69a20',
                            'background' => '#fff4dc',
                            'icon' => 'bi-clock-history',
                        ],
                        [
                            'name' => 'Processing',
                            'count' => $processingOrders,
                            'color' => '#4389d8',
                            'background' => '#e8f3ff',
                            'icon' => 'bi-arrow-repeat',
                        ],
                        [
                            'name' => 'Completed',
                            'count' => $completedOrders,
                            'color' => '#269b68',
                            'background' => '#e5f7ed',
                            'icon' => 'bi-check-circle',
                        ],
                        [
                            'name' => 'Cancelled',
                            'count' => $cancelledOrders,
                            'color' => '#d65b65',
                            'background' => '#ffe9eb',
                            'icon' => 'bi-x-circle',
                        ],
                    ];
                @endphp

                <div class="d-flex flex-column gap-3">

                    @foreach($statusDetails as $status)
                        @php
                            $percentage = $totalOrders > 0
                                ? ($status['count'] / $totalOrders) * 100
                                : 0;
                        @endphp

                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-2 d-flex align-items-center justify-content-center"
                                         style="width:34px;height:34px;background:{{ $status['background'] }};color:{{ $status['color'] }};">
                                        <i class="bi {{ $status['icon'] }}"></i>
                                    </div>

                                    <span class="fw-semibold small">
                                        {{ $status['name'] }}
                                    </span>
                                </div>

                                <span class="fw-bold"
                                      style="color:{{ $status['color'] }};">
                                    {{ number_format($status['count']) }}
                                </span>
                            </div>

                            <div class="progress"
                                 style="height:7px;background:#f0edf5;border-radius:20px;">
                                <div class="progress-bar"
                                     role="progressbar"
                                     style="width:{{ $percentage }}%;background:{{ $status['color'] }};border-radius:20px;"
                                     aria-valuenow="{{ $percentage }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3"
                     style="border-top:1px solid #eee8f8;">
                    <span class="text-secondary small">
                        Total Orders
                    </span>

                    <span class="fw-bold" style="color:#7138e5;">
                        {{ number_format($totalOrders) }}
                    </span>
                </div>

            </div>
        </div>

    </div>


    {{-- Low Stock Items --}}
    <div class="content-card p-4 mb-4"
         style="border:1px solid #eee8f8; border-radius:16px;">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h5 class="fw-bold mb-1" style="color:#25213b;">
                    Low Stock Items
                </h5>

                <p class="text-secondary small mb-0">
                    Inventory items that need attention
                </p>
            </div>

            <a href="{{ route('items.index') }}"
               class="small fw-semibold text-decoration-none"
               style="color:#7138e5;">
                View All Items <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($lowStockItems->isEmpty())
            <div class="text-center py-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:56px;height:56px;background:#e5f7ed;color:#269b68;">
                    <i class="bi bi-check-circle fs-3"></i>
                </div>

                <h6 class="fw-semibold">Inventory looks good!</h6>

                <p class="text-secondary small mb-0">
                    There are no low stock items.
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead>
                        <tr class="small text-secondary">
                            <th class="fw-semibold border-0">ITEM NAME</th>
                            <th class="fw-semibold border-0">DESCRIPTION</th>
                            <th class="fw-semibold border-0 text-end">STOCK</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($lowStockItems as $item)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $item->name }}
                                </td>

                                <td class="text-secondary small">
                                    {{ $item->description ?: 'No description' }}
                                </td>

                                <td class="text-end">
                                    @if($item->stock == 0)
                                        <span class="badge rounded-pill px-3 py-2"
                                              style="background:#ffe9eb;color:#c64c59;">
                                            Out of Stock
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2"
                                              style="background:#fff4dc;color:#bd8419;">
                                            {{ $item->stock }} left
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif

    </div>

@endsection
