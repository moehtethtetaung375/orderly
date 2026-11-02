
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Details | Order System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f0ff, #faf8ff);
            font-family: Arial, sans-serif;
            color: #17152f;
        }

        .page-wrapper {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .content-card {
            background: white;
            border: 1px solid #e7ddff;
            border-radius: 20px;
            box-shadow: 0 15px 45px rgba(91, 49, 180, .12);
            overflow: hidden;
        }

        .card-heading {
            padding: 25px 30px;
            color: white;
            background: linear-gradient(100deg, #7138e5, #803be8);
        }

        .card-body {
            padding: 30px;
        }

        .detail-box {
            height: 100%;
            padding: 16px;
            border: 1px solid #eee7ff;
            border-radius: 12px;
            background: #fdfcff;
        }

        .detail-label {
            color: #85809e;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .detail-value {
            font-size: 16px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .btn-purple {
            background: #7138e5;
            color: white;
            border: 0;
        }

        .btn-purple:hover {
            background: #5725c4;
            color: white;
        }

        .item-table th {
            color: #6b6284;
            font-size: 13px;
            white-space: nowrap;
        }
    </style>
</head>

<body>
<div class="page-wrapper">
    <div class="content-card">

        {{-- Header --}}
        <div class="card-heading d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="mb-0">
                <i class="bi bi-receipt me-2"></i>
                Order Details
            </h3>

            <span class="badge bg-light text-dark">
                Order #{{ $order->id }}
            </span>
        </div>

        <div class="card-body">

            {{-- Order information --}}
            <div class="row g-3">

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Customer Name</div>
                        <div class="detail-value">
                            {{ $order->user?->name ?? 'Unknown User' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Order Date</div>
                        <div class="detail-value">
                            {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            @php
                                $statusClass = match ($order->status) {
                                    'completed' => 'text-bg-success',
                                    'cancelled' => 'text-bg-danger',
                                    'pending' => 'text-bg-warning',
                                    default => 'text-bg-primary',
                                };
                            @endphp

                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Total Amount</div>
                        <div class="detail-value">
                            {{ number_format((float) $order->total_amount, 2) }}
                            MMK
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ordered items --}}
            <div class="mt-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-box-seam me-2"></i>
                    Ordered Items
                </h5>

                <div class="table-responsive">
                    <table class="table item-table align-middle">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($order->orderItems as $line)
                                <tr>
                                    <td>
                                        {{ $line->item?->name ?? 'Item unavailable' }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format((float) $line->unit_price, 2) }}
                                    </td>

                                    <td class="text-center">
                                        {{ $line->quantity }}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        {{ number_format((float) $line->unit_price * (int) $line->quantity, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary py-4">
                                        No items found for this order.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">
                                    Total Amount
                                </th>
                                <th class="text-end">
                                    {{ number_format((float) $order->total_amount, 2) }}
                                    MMK
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a
                    href="{{ route('orders.index') }}"
                    class="btn btn-outline-secondary"
                >
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Orders
                </a>

                @if (
                    !in_array($order->status, ['completed', 'cancelled'], true)
                    && (
                        auth()->user()->role === 'admin'
                        || $order->user_id === auth()->id()
                    )
                )
                    <a
                        href="{{ route('orders.edit', $order->id) }}"
                        class="btn btn-purple"
                    >
                        <i class="bi bi-pencil-square me-1"></i>
                        Edit Order
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>
</body>
</html>
