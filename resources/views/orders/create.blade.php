
@extends('layouts.app')

@push('styles')
<style>
    .order-create {
        color: #292640;
    }

    .order-create .eyebrow {
        color: #6d4aff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .order-create .page-title {
        font-weight: 750;
        letter-spacing: -0.7px;
    }

    .order-create .muted {
        color: #777b8b;
    }

    .order-create .panel {
        background: #fff;
        border: 1px solid #eceaf4;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(40, 30, 90, 0.045);
    }

    .order-create .section-title {
        font-weight: 700;
        font-size: 17px;
    }

    .order-create .form-control,
    .order-create .form-select {
        min-height: 44px;
        border-radius: 10px;
        border-color: #e4e1ef;
    }

    .order-create .form-control:focus,
    .order-create .form-select:focus {
        border-color: #6d4aff;
        box-shadow: 0 0 0 3px rgba(109, 74, 255, .12);
    }

    .order-create .btn-brand {
        background: #6d4aff;
        border-color: #6d4aff;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        padding: 11px 17px;
    }

    .order-create .btn-brand:hover {
        background: #5635db;
        color: white;
    }

    .order-create .btn-light-custom {
        background: #f5f3ff;
        color: #5635db;
        border: 1px solid #e7e0ff;
        border-radius: 10px;
    }

    .order-create .item-row {
        padding: 17px 0;
        border-bottom: 1px solid #f0eef6;
    }

    .order-create .item-row:last-child {
        border-bottom: 0;
    }

    .order-create .item-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 13px;
        background: #f2efff;
        color: #6d4aff;
        font-size: 19px;
    }

    .order-create .item-price {
        color: #5635db;
        font-weight: 700;
    }

    .order-create .stock-label {
        font-size: 12px;
        color: #777b8b;
    }

    .order-create .quantity-input {
        width: 92px;
        min-height: 40px;
        text-align: center;
    }

    .order-create .summary-box {
        background: #f8f6ff;
        border: 1px solid #ece5ff;
        border-radius: 14px;
    }

    .order-create .total-value {
        color: #5635db;
        font-size: 26px;
        font-weight: 800;
    }

    .order-create .step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 9px;
        background: #f0ebff;
        color: #6d4aff;
        font-size: 13px;
        font-weight: 700;
        margin-right: 9px;
    }

    .order-create .empty-items {
        padding: 35px 15px;
        text-align: center;
        color: #777b8b;
    }

    @media (max-width: 575px) {
        .order-create .quantity-input {
            width: 76px;
        }

        .order-create .total-value {
            font-size: 23px;
        }
    }
</style>
@endpush

@section('content')
<div class="container pt-2 pb-4 order-create">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="eyebrow mb-2">ORDERLY / ORDERS</div>
            <h2 class="page-title mb-2">Create New Order</h2>
            <p class="muted mb-0">
                Select items and quantities to create your order.
            </p>
        </div>

        <a href="{{ route('orders.index') }}"
           class="btn btn-light-custom px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Orders
        </a>
    </div>

    <form action="{{ route('orders.store') }}"
          method="POST"
          id="create-order-form">
        @csrf

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="panel p-3 p-lg-4">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div>
                            <h5 class="section-title mb-1">
                                <span class="step-number">1</span>
                                Select Items
                            </h5>
                            <p class="muted small mb-0 ms-1">
                                Choose one or more items for this order.
                            </p>
                        </div>

                        <span class="badge rounded-pill px-3 py-2"
                              style="background:#f0ebff;color:#5635db;">
                            {{ $items->count() }} available
                        </span>
                    </div>

                    <div class="mb-3">
                        <input type="search"
                               id="item-search"
                               class="form-control"
                               placeholder="Search items by name...">
                    </div>

                    @forelse($items as $item)
                        <div class="item-row item-option"
                             data-name="{{ strtolower($item->name) }}">

                            <div class="d-flex align-items-center gap-3">

                                <div class="item-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <div class="w-100 min-w-0">
                                    <div class="fw-semibold item-name">
                                        {{ $item->name }}
                                    </div>

                                    <div class="muted small">
                                        {{ $item->description ?: 'No description available' }}
                                    </div>

                                    <div class="item-price mt-1">
                                        {{ number_format((float) $item->price, 2) }}
                                    </div>

                                    <div class="stock-label mt-1">
                                        <i class="bi bi-box me-1"></i>
                                        {{ $item->stock }} in stock
                                    </div>
                                </div>

                                <div class="text-end">
                                    <label for="item-{{ $item->id }}"
                                           class="form-label small fw-semibold">
                                        Quantity
                                    </label>
                                    
                                    <input
                                        type="number"
                                        name="items[{{ $item->id }}][quantity]"
                                        class="form-control quantity-input item-quantity"
                                        id="item-{{ $item->id }}"
                                        min="1"
                                        max="{{ $item->stock }}"
                                        value="{{ old('items.'.$item->id.'.quantity', 1) }}"
                                        data-item-id="{{ $item->id }}"
                                        data-price="{{ $item->price }}"
                                        data-stock="{{ $item->stock }}"
                                        disabled
                                    >

                                    <div class="form-check mt-2">
                                        
                                        <input
                                            class="form-check-input item-checkbox"
                                            type="checkbox"
                                            id="select-{{ $item->id }}"
                                            name="items[{{ $item->id }}][selected]"
                                            value="1"
                                            data-item-id="{{ $item->id }}"
                                            {{ old('items.'.$item->id.'.selected') ? 'checked' : '' }}
                                            {{ $item->stock < 1 ? 'disabled' : '' }}
                                        >

                                        <label class="form-check-label small"
                                               for="select-{{ $item->id }}">
                                            Select
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="empty-items">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            <h6 class="fw-bold text-dark">No items available</h6>
                            <p class="mb-0">
                                There are no items in stock to order.
                            </p>
                        </div>
                    @endforelse

                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel p-3 p-lg-4">

                    <h5 class="section-title mb-1">
                        <span class="step-number">2</span>
                        Order Summary
                    </h5>

                    <p class="muted small mb-4">
                        Review your selection before submitting.
                    </p>

                    <div id="selected-items-summary">
                        <div class="text-center muted py-4">
                            <i class="bi bi-cart3 fs-2 d-block mb-2"></i>
                            No items selected yet.
                        </div>
                    </div>

                    <hr style="border-color:#eceaf4;">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="muted">Selected items</span>
                        <strong id="selected-count">0</strong>
                    </div>

                    <div class="summary-box p-3 mb-4">
                        <div class="muted small mb-1">Estimated total</div>
                        <div class="total-value">
                            <span id="estimated-total">0.00</span>
                        </div>
                        <div class="muted small mt-1">
                            Final total is calculated by the server.
                        </div>
                    </div>
                                        
                    <button type="submit"
                            class="btn btn-brand w-100"
                            id="submit-order"
                            disabled>
                        <i class="bi bi-check2-circle me-1"></i>
                        Create Order
                    </button>

                    <a href="{{ route('orders.index') }}"
                       class="btn btn-light w-100 mt-2 rounded-3">
                        Cancel
                    </a>

                    <div class="muted small text-center mt-3">
                        <i class="bi bi-shield-check me-1"></i>
                        Your order will be saved securely.
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('create-order-form');
    const checkboxes = Array.from(document.querySelectorAll('.item-checkbox'));
    const summary = document.getElementById('selected-items-summary');
    const selectedCount = document.getElementById('selected-count');
    const estimatedTotal = document.getElementById('estimated-total');
    const submitButton = document.getElementById('submit-order');
    const searchInput = document.getElementById('item-search');

    function escapeHtml(value) {
        return value.replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[character];
        });
    }

    function updateSummary() {
        let total = 0;
        let count = 0;
        let html = '';

        checkboxes.forEach(function (checkbox) {
            const id = checkbox.dataset.itemId;
            const quantityInput = document.querySelector(
                '.item-quantity[data-item-id="' + id + '"]'
            );

            if (!quantityInput) return;

            const row = checkbox.closest('.item-option');
            const name = row.querySelector('.item-name').textContent.trim();
            const price = Number(quantityInput.dataset.price);
            const quantity = Number(quantityInput.value || 0);

            quantityInput.disabled = !checkbox.checked;
            quantityInput.required = checkbox.checked;

            if (checkbox.checked) {
                total += price * quantity;
                count++;

                html += `
                    <div class="d-flex justify-content-between gap-2 mb-3">
                        <div>
                            <div class="fw-semibold small">${escapeHtml(name)}</div>
                            <div class="muted small">${quantity} × ${price.toFixed(2)}</div>
                        </div>
                        <div class="fw-semibold text-nowrap">${(price * quantity).toFixed(2)}</div>
                    </div>
                `;
            }
        });

        summary.innerHTML = html || `
            <div class="text-center muted py-4">
                <i class="bi bi-cart3 fs-2 d-block mb-2"></i>
                No items selected yet.
            </div>
        `;

        selectedCount.textContent = count;
        estimatedTotal.textContent = total.toFixed(2);
        submitButton.disabled = count === 0;
    }

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', updateSummary);
    });

    document.querySelectorAll('.item-quantity').forEach(function (input) {
        input.addEventListener('input', function () {
            const stock = Number(input.dataset.stock);
            const value = Number(input.value);

            if (value > stock) input.value = stock;

            updateSummary();
        });
    });

    searchInput.addEventListener('input', function () {
        const term = searchInput.value.toLowerCase().trim();

        document.querySelectorAll('.item-option').forEach(function (row) {
            row.style.display = row.dataset.name.includes(term) ? '' : 'none';
        });
    });

    
    form.addEventListener('submit', function (event) {
        const selected = checkboxes.filter(function (checkbox) {
            return checkbox.checked;
        });

        if (selected.length === 0) {
            event.preventDefault();
            alert('Please select at least one item.');
            return;
        }

        selected.forEach(function (checkbox) {
            const id = checkbox.dataset.itemId;

            const quantityInput = document.querySelector(
                '.item-quantity[data-item-id="' + id + '"]'
            );

            quantityInput.name = 'items[' + id + '][quantity]';
            quantityInput.disabled = false;
        });
    });

    updateSummary();
});
</script>
@endpush
