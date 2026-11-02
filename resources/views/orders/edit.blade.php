@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<style>
    .edit-order-wrapper {
        max-width: 900px;
        margin: 25px auto;
    }

    .edit-order-card {
        background: #fff;
        border: 1px solid #e7ddff;
        border-radius: 20px;
        box-shadow: 0 15px 45px rgba(91, 49, 180, .10);
        overflow: hidden;
    }

    .edit-order-heading {
        padding: 25px 30px;
        color: #fff;
        background: linear-gradient(100deg, #7138e5, #5926c4);
    }

    .edit-order-body {
        padding: 30px;
    }

    .edit-order-body .form-label {
        font-weight: 600;
        font-size: 14px;
    }

    .edit-order-body .form-control,
    .edit-order-body .form-select {
        min-height: 43px;
        border: 1px solid #ded4f8;
        border-radius: 10px;
    }

    .edit-order-body .form-control:focus,
    .edit-order-body .form-select:focus {
        border-color: #8248ed;
        box-shadow: 0 0 0 4px rgba(130, 72, 237, .12);
    }

    .edit-order-body .form-control[readonly] {
        background: #f5f2fc;
    }

    .edit-section-title {
        color: #5926c4;
        font-weight: 700;
        font-size: 17px;
    }

    .edit-item-row {
        border: 1px solid #e8e1f8;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
        transition: background .2s ease, border-color .2s ease;
    }

    .edit-item-row.selected {
        background: #f7f2ff;
        border-color: #cbb7ff;
    }

    .edit-item-price {
        color: #7138e5;
        font-weight: 700;
    }

    .edit-quantity {
        max-width: 105px;
    }

    .edit-total-panel {
        padding: 18px;
        background: #f7f2ff;
        border: 1px solid #e4d9ff;
        border-radius: 12px;
    }

    .edit-total-value {
        color: #5926c4;
        font-size: 22px;
        font-weight: 800;
    }

    .btn-edit-purple {
        background: linear-gradient(135deg, #8050ed, #7138e5, #5926c4);
        color: #fff;
        border: 1px solid #7138e5;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 700;
    }

    .btn-edit-purple:hover {
        background: #5926c4;
        color: #fff;
    }

    @media (max-width: 576px) {
        .edit-order-body {
            padding: 20px 16px;
        }

        .edit-order-heading {
            padding: 22px 20px;
        }
    }
</style>

<div class="edit-order-wrapper">
    <div class="edit-order-card">

        <div class="edit-order-heading">
            <h3 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Order #{{ $order->id }}
            </h3>

            <p class="mb-0 mt-2">
                Update your existing items or add more food items.
            </p>
        </div>

        <div class="edit-order-body">

            <form
                action="{{ route('orders.update', $order->id) }}"
                method="POST"
                id="editOrderForm"
            >
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="customer_name" class="form-label">
                        Customer Name
                    </label>

                    <input
                        type="text"
                        id="customer_name"
                        class="form-control"
                        value="{{ $order->user?->name ?? 'Unknown User' }}"
                        readonly
                    >
                </div>

                <div class="mb-3">
                    <label for="order_date" class="form-label">
                        Order Date
                    </label>

                    <input
                        type="text"
                        id="order_date"
                        class="form-control"
                        value="{{ $order->created_at?->format('d M Y, h:i:s A') ?? 'N/A' }}"
                        readonly
                    >
                </div>

                <div class="mb-4">
                    <label for="updated_at" class="form-label">
                        Last Edited Time
                    </label>

                    <input
                        type="text"
                        id="updated_at"
                        class="form-control"
                        value="{{ $order->updated_at?->format('d M Y, h:i:s A') ?? 'Not edited yet' }}"
                        readonly
                    >

                    <small class="text-secondary">
                        This time updates automatically when the order is saved.
                    </small>
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">
                        Order Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >
                        @php
                            $statuses = auth()->user()->role === 'admin'
                                ? ['pending', 'processing', 'completed', 'cancelled']
                                : ['pending', 'cancelled'];
                        @endphp

                        @foreach ($statuses as $status)
                            <option
                                value="{{ $status }}"
                                {{ old('status', $order->status) === $status ? 'selected' : '' }}
                            >
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr class="my-4">

                <h5 class="edit-section-title mb-3">
                    <i class="bi bi-egg-fried me-2"></i>
                    Order Items
                </h5>

                <p class="text-secondary small">
                    Your existing items are selected automatically.
                    Change quantities, add new items, or uncheck items you no longer want.
                </p>

                @php
                    /*
                     * Use old input after validation fails.
                     * Otherwise, load the current order's existing lines.
                     */
                    $oldItems = old('items');

                    $selectedItems = is_array($oldItems)
                        ? $oldItems
                        : $order->orderItems
                            ->mapWithKeys(function ($line) {
                                return [
                                    $line->item_id => [
                                        'selected' => '1',
                                        'quantity' => $line->quantity,
                                    ],
                                ];
                            })
                            ->all();

                    /*
                     * Remember the quantities already included in this order.
                     * Those quantities can be added back to the item's current stock
                     * when calculating the maximum quantity during editing.
                     */
                    $existingQuantities = $order->orderItems
                        ->pluck('quantity', 'item_id')
                        ->all();
                @endphp

                <div id="editItemsContainer">
                    @forelse ($items as $item)
                        @php
                            $rowData = $selectedItems[$item->id] ?? [];

                            $selected = is_array($rowData)
                                && !empty($rowData['selected']);

                            $quantity = (int) (
                                $rowData['quantity'] ?? 1
                            );

                            $quantity = max(1, $quantity);

                            $previousQuantity = (int) (
                                $existingQuantities[$item->id] ?? 0
                            );

                            $maxQuantity = (int) $item->stock
                                + $previousQuantity;

                            $maxQuantity = max(1, $maxQuantity);
                        @endphp

                        <div
                            class="edit-item-row {{ $selected ? 'selected' : '' }}"
                            data-price="{{ $item->price }}"
                        >
                            <div class="row align-items-center g-3">

                                <div class="col-1">
                                    <input
                                        class="form-check-input edit-item-checkbox"
                                        type="checkbox"
                                        name="items[{{ $item->id }}][selected]"
                                        value="1"
                                        aria-label="Select {{ $item->name }}"
                                        {{ $selected ? 'checked' : '' }}
                                    >
                                </div>

                                <div class="col-7">
                                    <div class="fw-semibold">
                                        {{ $item->name }}
                                    </div>

                                    @if ($item->description)
                                        <div class="text-secondary small">
                                            {{ $item->description }}
                                        </div>
                                    @endif

                                    <div class="edit-item-price mt-1">
                                        {{ number_format((float) $item->price, 2) }} MMK
                                    </div>

                                    <small class="text-secondary">
                                        Available stock: {{ $item->stock }}

                                        @if ($previousQuantity > 0)
                                            <span class="text-primary">
                                                ({{ $previousQuantity }} already in this order)
                                            </span>
                                        @endif
                                    </small>
                                </div>

                                <div class="col-4">
                                    <label
                                        for="edit_quantity_{{ $item->id }}"
                                        class="form-label small mb-1"
                                    >
                                        Quantity
                                    </label>

                                    <input
                                        type="number"
                                        id="edit_quantity_{{ $item->id }}"
                                        name="items[{{ $item->id }}][quantity]"
                                        class="form-control edit-quantity edit-item-quantity"
                                        min="1"
                                        max="{{ $maxQuantity }}"
                                        value="{{ $quantity }}"
                                        {{ $selected ? '' : 'disabled' }}
                                    >
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">
                            No food items are available for this order.
                        </div>
                    @endforelse
                </div>

                @error('items')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <div class="edit-total-panel mt-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <span class="fw-semibold">Total Amount</span>

                        <span class="edit-total-value text-end">
                            <span id="editTotalAmount">0.00</span> MMK
                        </span>
                    </div>

                    <div class="text-secondary small mt-2">
                        The final total is calculated and saved by the server.
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a
                        href="{{ route('orders.index', $order->id) }}"
                        class="btn btn-outline-secondary rounded-3 px-3"
                    >
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-edit-purple"
                    >
                        <i class="bi bi-check-circle me-1"></i>
                        Update Order
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.edit-item-row');
    const totalElement = document.getElementById('editTotalAmount');
    const form = document.getElementById('editOrderForm');

    function updateTotal() {
        let total = 0;

        rows.forEach(function (row) {
            const checkbox = row.querySelector('.edit-item-checkbox');
            const quantityInput = row.querySelector('.edit-item-quantity');
            const price = Number(row.dataset.price) || 0;

            quantityInput.disabled = !checkbox.checked;

            row.classList.toggle(
                'selected',
                checkbox.checked
            );

            if (checkbox.checked) {
                const quantity = Number(quantityInput.value) || 0;
                total += price * quantity;
            }
        });

        totalElement.textContent = total.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    rows.forEach(function (row) {
        const checkbox = row.querySelector('.edit-item-checkbox');
        const quantityInput = row.querySelector('.edit-item-quantity');

        checkbox.addEventListener('change', updateTotal);
        quantityInput.addEventListener('input', updateTotal);
    });

    form.addEventListener('submit', function (event) {
        const selectedCheckboxes = document.querySelectorAll(
            '.edit-item-checkbox:checked'
        );

        if (selectedCheckboxes.length === 0) {
            event.preventDefault();

            alert('Please select at least one food item.');

            return;
        }

        let invalidQuantity = false;

        selectedCheckboxes.forEach(function (checkbox) {
            const row = checkbox.closest('.edit-item-row');
            const quantityInput = row.querySelector('.edit-item-quantity');

            const quantity = Number(quantityInput.value);
            const maxQuantity = Number(quantityInput.max);

            if (
                !Number.isInteger(quantity) ||
                quantity < 1 ||
                quantity > maxQuantity
            ) {
                invalidQuantity = true;
                quantityInput.classList.add('is-invalid');
            } else {
                quantityInput.classList.remove('is-invalid');
            }
        });

        if (invalidQuantity) {
            event.preventDefault();

            alert(
                'Please enter a valid quantity within the available stock.'
            );
        }
    });

    updateTotal();
});
</script>
@endsection