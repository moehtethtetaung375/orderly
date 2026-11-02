@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <style>
        .order-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            width: 65px;
            padding: 7px 5px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-view {
            background: #f3efff;
            color: #6535d9;
            border: 1px solid #e0d5ff;
        }

        .btn-view:hover {
            background: #6535d9;
            color: #fff;
            border-color: #6535d9;
        }

        .btn-edit {
            background: #edf5ff;
            color: #2463c9;
            border: 1px solid #cfe2ff;
        }

        .btn-edit:hover {
            background: #2463c9;
            color: #fff;
            border-color: #2463c9;
        }

        .btn-delete {
            background: #fff0f0;
            color: #c83232;
            border: 1px solid #ffd5d5;
        }

        .btn-delete:hover {
            background: #c83232;
            color: #fff;
            border-color: #c83232;
        }

        .order-action-column {
            width: 250px;
            white-space: nowrap;
        }

        .order-action-form {
            display: inline-flex;
            margin: 0;
        }

        .order-total {
            text-align: right;
            white-space: nowrap;
            font-weight: 600;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                {{ auth()->user()->role === 'admin' ? 'All Orders' : 'My Orders' }}
            </h2>

            <p class="text-secondary mb-0">
                View and track your orders.
            </p>
        </div>

        <a href="{{ route('orders.create') }}" class="btn btn-purple">
            <i class="bi bi-plus-lg"></i>
            Create Order
        </a>
    </div>

    <div class="content-card p-4">

        <div class="content-card p-3 mb-3">
            <form action="{{ route('orders.index') }}" method="GET">
                <div class="d-flex justify-content-between align-items-center gap-2">

                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search text-secondary"></i>
                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search order ID, status or food name..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-purple">
                            Search
                        </button>

                        @if(request('search'))
                            <a href="{{ route('orders.index') }}"
                                class="btn btn-outline-secondary">
                                Clear
                            </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>

<div class="content-card p-4">
        @if ($orders->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-receipt display-4" style="color: #7138e5;"></i>

                <h5 class="mt-3">No orders yet</h5>

                <p class="text-secondary">
                    Your orders will appear here when you create one.
                </p>

                <a href="{{ route('orders.create') }}" class="btn btn-purple">
                    Create Your First Order
                </a>
            </div>
        @else
        
            <div class="d-flex justify-content-end mb-2">
                <div class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-2"
                    style="background-color: #f1ebff;
                            border: 1px solid #e4d8ff;
                            color: #7138e5;
                            font-size: 12px;">

                    <i class="bi bi-receipt" style="font-size: 12px;"></i>

                    <span class="fw-medium">
                        {{ $totalOrders }}
                        {{ $totalOrders === 1 ? 'Order' : 'Orders' }}
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            @if (auth()->user()->role === 'admin')
                                <th>User Name</th>
                            @endif
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                            <th class="order-action-column">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="fw-semibold">
                                    #{{ $order->id }}
                                </td>
                                @if (auth()->user()->role === 'admin')
                                    <td>
                                        <span class="fw-semibold">
                                            {{ $order->user->name ?? 'Unknown User' }}
                                        </span>
                                    </td>
                                @endif
                                <td>
                                    {{ $order->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                <td>
                                    @php
                                        $status = strtolower($order->status ?? 'pending');

                                        $statusColors = [
                                            'pending' => 'bg-warning text-dark',
                                            'processing' => 'bg-primary',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                        ];
                                    @endphp

                                    <span class="badge rounded-pill {{ $statusColors[$status] ?? 'bg-secondary' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <td class="order-total">
                                    {{ number_format((float) $order->total_amount, 2) }}
                                </td>

                                <td class="order-action-column">
                                    <div class="d-flex align-items-center gap-1">
                                        <a
                                            href="{{ route('orders.show', $order) }}"
                                            class="btn btn-sm btn-view order-action-btn"
                                        >
                                            <i class="bi bi-eye me-1"></i>
                                            View
                                        </a>

                                        <a
                                            href="{{ route('orders.edit', $order) }}"
                                            class="btn btn-sm btn-edit order-action-btn"
                                        >
                                            <i class="bi bi-pencil-square me-1"></i>
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('orders.destroy', $order) }}"
                                            method="POST"
                                            class="order-action-form"
                                            onsubmit="return confirm('Are you sure you want to delete this order?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-delete order-action-btn"
                                            >
                                                <i class="bi bi-trash me-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
