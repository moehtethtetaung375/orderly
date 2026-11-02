@extends('layouts.app')

@push('styles')
<style>
    .items-page {
        --brand: #6d4aff;
        --brand-dark: #5635db;
        --surface: #ffffff;
        --muted: #777b8b;
        --line: #ececf4;
        color: #25243a;
    }

    .items-page .page-heading {
        font-weight: 750;
        letter-spacing: -0.8px;
    }

    .items-page .subtitle {
        color: var(--muted);
    }

    .items-page .panel {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(40, 30, 90, 0.045);
    }

    .items-page .search-input {
        min-height: 46px;
        border: 1px solid #e4e1ef;
        border-radius: 11px;
        padding-left: 14px;
    }

    .items-page .search-input:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(109, 74, 255, 0.12);
    }

    .items-page .btn-brand {
        background: linear-gradient(135deg, #8050ed, #7138e5, #5926c4);
        border: 1px solid #7138e5;
        color: #fff;
        border-radius: 11px;
        padding: 10px 18px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(113, 56, 229, 0.20);
        transition: all 0.2s ease;
    }

    .items-page .btn-brand:hover {
        background: linear-gradient(135deg, #7138e5, #5926c4);
        border-color: #5926c4;
        color: #fff;
    }

    .items-page .table thead th {
        background: #f8f7fc;
        color: #77748b;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        padding: 15px 18px;
        border-bottom: 1px solid var(--line);
        white-space: nowrap;
    }

    .items-page .table tbody td {
        padding: 17px 18px;
        border-color: #f0eff6;
        vertical-align: middle;
    }

    .items-page .table tbody tr:hover {
        background: #fbfaff;
    }

    .items-page .item-id {
        color: #89869a;
        font-weight: 600;
    }

    .items-page .item-name {
        color: #30264f;
        font-weight: 650;
    }

    .items-page .item-description {
        color: var(--muted);
        max-width: 300px;
    }

    .items-page .price {
        color: var(--brand-dark);
        font-weight: 700;
        white-space: nowrap;
    }

    .items-page .stock-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 8px;
        background: #f0f7f2;
        color: #27824b;
        font-size: 12px;
        font-weight: 700;
    }

    .items-page .stock-empty {
        background: #fff0f0;
        color: #c24141;
    }

    .items-page .result-count {
        background: #f3f0ff;
        color: var(--brand-dark);
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    /* Common style for View, Edit and Delete */
    .items-page .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        padding: 7px 12px;
        transition: all 0.2s ease;
    }

    /* View button - Purple */
    .items-page .btn-view {
        background: #f3efff;
        color: #6535d9;
        border: 1px solid #e0d5ff;
    }

    .items-page .btn-view:hover {
        background: #6535d9;
        color: #fff;
        border-color: #6535d9;
    }

    /* Edit button - Blue */
    .items-page .btn-edit {
        background: #edf5ff;
        color: #2463c9;
        border: 1px solid #cfe2ff;
    }

    .items-page .btn-edit:hover {
        background: #2463c9;
        color: #fff;
        border-color: #2463c9;
    }

    /* Delete button - Red */
    .items-page .btn-delete {
        background: #fff0f0;
        color: #c83232;
        border: 1px solid #ffd5d5;
    }

    .items-page .btn-delete:hover {
        background: #c83232;
        color: #fff;
        border-color: #c83232;
    }

    .items-page .empty-state {
        padding: 55px 20px;
        text-align: center;
        color: var(--muted);
    }

    .items-page .empty-icon {
        width: 58px;
        height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        background: #f3f0ff;
        color: var(--brand);
        font-size: 25px;
        margin-bottom: 15px;
    }

    .items-page nav[aria-label="Pagination Navigation"] {
        margin-top: 22px;
    }

    .items-page .pagination {
        gap: 5px;
        margin-bottom: 0;
        flex-wrap: wrap;
    }

    .items-page .page-link {
        border-radius: 8px !important;
        border: 1px solid var(--line);
        color: #51466e;
    }

    .items-page .page-item.active .page-link {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }

    @media (max-width: 767px) {
        .items-page .page-heading {
            font-size: 25px;
        }

        .items-page .table thead th,
        .items-page .table tbody td {
            padding: 13px 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="container pt-0 pb-4 items-page">

    {{-- Page Heading --}}
    <div class="d-flex flex-wrap justify-content-between
                align-items-center gap-3 mb-4">

        <div>
            <div class="small fw-semibold mb-2"
                 style="color: #7138e5; letter-spacing: 1.5px;">
                ORDERLY / INVENTORY
            </div>

            <h2 class="page-heading mb-2">Items Management</h2>

            <p class="subtitle mb-0">
                Browse, search and manage your items in one place.
            </p>
        </div>

        {{-- Add New Item --}}
        <a href="{{ route('items.create') }}" class="btn-brand">
            <i class="bi bi-plus-lg me-2"></i>
            Add New Item
        </a>
    </div>

    {{-- Search Panel --}}
    <div class="panel p-3 p-lg-4 mb-4">
        <form action="{{ route('items.index') }}" method="GET">

            <div class="row g-2">
                
                <div class="d-flex gap-2 align-items-center">
                    <input
                        type="search"
                        name="search"
                        class="form-control"
                        placeholder="Enter item name or description..."
                        value="{{ request('search') }}"
                    >

                    <button type="submit" class="btn btn-purple shrink-0">
                        Search
                    </button>

                    @if(request('search'))
                        <a href="{{ route('items.index') }}"
                        class="btn btn-outline-secondary shrink-0">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Items Table Panel --}}
    <div class="panel overflow-hidden">

        <div class="d-flex flex-wrap justify-content-between
                    align-items-center gap-2 p-3 p-lg-4">

            <div>
                <h5 class="fw-bold mb-1">All Items</h5>

                <div class="small subtitle">
                    Manage your item catalogue.
                </div>
            </div>

            <div class="d-flex justify-content-end mb-2">
                <div class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-2"
                    style="background-color: #f1ebff;
                            border: 1px solid #e4d8ff;
                            color: #7138e5;
                            font-size: 12px;">

                    <i class="bi bi-box-seam" style="font-size: 12px;"></i>

                    <span class="fw-medium">
                        {{ $items->total() }}
                        {{ $items->total() === 1 ? 'Item' : 'Items' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Orders</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td class="item-id">
                                #{{ $item->id }}
                            </td>
                            <td>
                                @if ($item->image)
                                    <img
                                        src="{{ asset('storage/' . $item->image) }}"
                                        alt="{{ $item->name }}"
                                        style="width: 55px; height: 55px; object-fit: cover; border-radius: 8px;"
                                    >
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </td>

                            <td>
                                <div class="item-name">
                                    {{ $item->name }}
                                </div>
                            </td>

                            <td>
                                <div class="item-description">
                                    {{ $item->description ?: 'No description' }}
                                </div>
                            </td>

                            <td class="price">
                                {{ number_format((float) $item->price, 2) }}
                            </td>

                            <td>
                                <span class="stock-badge
                                    {{ $item->stock < 1 ? 'stock-empty' : '' }}">
                                    {{ $item->stock }}
                                </span>
                            </td>

                            <td>
                                <span class="stock-badge">
                                    {{ $item->orders_count ?? 0 }}
                                </span>
                            </td>

                            {{-- Action Buttons --}}
                            <td>
                                <div class="d-flex flex-wrap gap-2">

                                    {{-- View Button --}}
                                    <a href="{{ route('items.show', $item->id) }}"
                                       class="btn btn-sm btn-view action-btn">
                                        <i class="bi bi-eye me-1"></i>
                                        View
                                    </a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('items.edit', $item->id) }}"
                                       class="btn btn-sm btn-edit action-btn">
                                        <i class="bi bi-pencil-square me-1"></i>
                                        Edit
                                    </a>

                                    {{-- Delete Button --}}
                                    <form
                                        action="{{ route('items.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this item?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-delete action-btn">
                                            <i class="bi bi-trash me-1"></i>
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-search"></i>
                                    </div>

                                    <h5 class="fw-bold text-dark">
                                        No items found
                                    </h5>

                                    <p class="mb-3">
                                        @if(request('search'))
                                            No items match
                                            "{{ request('search') }}".
                                            Try another keyword.
                                        @else
                                            There are no items to display yet.
                                        @endif
                                    </p>

                                    @if(request('search'))
                                        <a href="{{ route('items.index') }}"
                                           class="btn btn-brand">
                                            Clear Search
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($items->hasPages())
            <div class="d-flex flex-wrap justify-content-between
                        align-items-center gap-3 p-3 p-lg-4 border-top">

                <div class="small subtitle">
                    Showing {{ $items->firstItem() ?? 0 }}
                    to {{ $items->lastItem() ?? 0 }}
                    of {{ $items->total() }} items
                </div>

                <div>
                    {{ $items->appends(request()->query())->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection