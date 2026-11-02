@extends('layouts.app')

@section('title', 'Create Item')
@section('page_heading', 'Create New Item')

@section('content')

<style>
    .item-create-page {
        max-width: 1000px;
        margin: 0 auto;
        padding-bottom: 30px;
    }

    .create-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .create-header h2 {
        margin: 0 0 8px;
        color: #211747;
        font-size: 27px;
        font-weight: 750;
    }

    .create-header p {
        margin: 0;
        color: #85809e;
        font-size: 14px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        border: 1px solid #e4dcf8;
        border-radius: 10px;
        background: #fff;
        color: #6840cb;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .back-link:hover {
        background: #f6f1ff;
        color: #4d24b5;
    }

    .create-card {
        overflow: hidden;
        border: 1px solid #e9e2f8;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(60, 35, 120, 0.06);
    }

    .create-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 24px 28px;
        border-bottom: 1px solid #eee9f8;
        background: linear-gradient(110deg, #faf8ff, #fff);
    }

    .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        border-radius: 14px;
        background: #eee6ff;
        color: #7138e5;
        font-size: 25px;
    }

    .create-card-header h3 {
        margin: 0 0 5px;
        color: #211747;
        font-size: 18px;
        font-weight: 700;
    }

    .create-card-header p {
        margin: 0;
        color: #85809e;
        font-size: 13px;
    }

    .create-form {
        padding: 30px;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0 0 23px;
        color: #38236e;
        font-size: 15px;
        font-weight: 700;
    }

    .form-section-title i {
        color: #7138e5;
        font-size: 18px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 9px;
        color: #342b53;
        font-size: 13px;
        font-weight: 650;
    }

    .required-mark {
        color: #e54868;
    }

    .optional-label {
        color: #9992ad;
        font-weight: 400;
    }

    .item-input,
    .item-textarea {
        display: block;
        width: 100%;
        border: 1px solid #e2daf4;
        border-radius: 10px;
        background: #fdfcff;
        color: #2d2548;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .item-input {
        min-height: 48px;
        padding: 12px 15px;
    }

    .item-textarea {
        min-height: 130px;
        padding: 14px 15px;
        resize: vertical;
    }

    .item-input:focus,
    .item-textarea:focus {
        outline: none;
        border-color: #8a5aef;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(113, 56, 229, .09);
    }

    .item-input::placeholder,
    .item-textarea::placeholder {
        color: #aaa4bc;
    }

    .field-hint {
        display: block;
        margin-top: 7px;
        color: #9992ad;
        font-size: 12px;
    }

    .field-error {
        display: block;
        margin-top: 7px;
        color: #dc3545;
        font-size: 12px;
    }

    .form-divider {
        height: 1px;
        margin: 30px 0;
        background: #eee9f8;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid #eee9f8;
    }

    .btn-cancel,
    .btn-create {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 46px;
        padding: 11px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .btn-cancel {
        border: 1px solid #e2daf4;
        background: #fff;
        color: #6f6689;
    }

    .btn-cancel:hover {
        background: #f7f4fc;
        color: #4d3d72;
    }

    .btn-create {
        border: 1px solid #7138e5;
        background: linear-gradient(100deg, #7138e5, #8045ee);
        color: #fff;
        box-shadow: 0 5px 14px rgba(113, 56, 229, .18);
    }

    .btn-create:hover {
        background: #5d2bc9;
        color: #fff;
        transform: translateY(-1px);
    }

    .form-notice {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 24px;
        padding: 15px;
        border: 1px solid #e6ddff;
        border-radius: 10px;
        background: #faf7ff;
        color: #76669e;
        font-size: 12px;
        line-height: 1.7;
    }

    .form-notice i {
        color: #7138e5;
        font-size: 17px;
    }

    @media (max-width: 600px) {
        .create-header {
            align-items: flex-start;
        }

        .create-header h2 {
            font-size: 22px;
        }

        .create-header p {
            line-height: 1.6;
        }

        .back-link {
            padding: 9px 11px;
            font-size: 12px;
        }

        .create-card-header {
            padding: 20px;
        }

        .create-form {
            padding: 22px 18px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-create {
            width: 100%;
        }
    }
</style>

<div class="item-create-page">

    <!-- Page heading -->
    <div class="create-header">
        <div>
            <h2>Create New Item</h2>
            <p>Add a new item to your Orderly inventory.</p>
        </div>

        <a href="{{ route('items.index') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Back to Items
        </a>
    </div>

    

    <!-- Create form card -->
    <div class="create-card">

        <div class="create-card-header">
            <div class="header-icon">
                <i class="bi bi-box-seam"></i>
            </div>

            <div>
                <h3>Item Information</h3>
                <p>Enter the details for the new item below.</p>
            </div>
        </div>

        <form action="{{ route('items.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="create-form">

            @csrf

            <!-- Basic information -->
            <h4 class="form-section-title">
                <i class="bi bi-info-circle"></i>
                Basic Information
            </h4>

            <!-- Item Name -->
            <div class="form-group">
                <label for="name" class="form-label">
                    Item Name <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="item-input @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="e.g. Something..."
                    maxlength="255"
                    required
                    autofocus
                >

                <span class="field-hint">
                    Enter a clear name that identifies the item.
                </span>

                @error('name')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">
                    Description
                    <span class="optional-label">(Optional)</span>
                </label>

                <textarea
                    name="description"
                    id="description"
                    class="item-textarea @error('description') is-invalid @enderror"
                    placeholder="Describe the item, its features, or other useful details..."
                >{{ old('description') }}</textarea>

                <span class="field-hint">
                    Provide additional information about this item if needed.
                </span>

                @error('description')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Item Image --}}
            <div class="form-group">
                <label for="image" class="form-label">
                    Item Image
                    <span class="optional-label">(Optional)</span>
                </label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    class="item-input @error('image') is-invalid @enderror"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <span class="field-hint">
                    Upload an item image. Supported formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                </span>

                @error('image')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-divider"></div>

            <!-- Pricing and stock -->
            <h4 class="form-section-title">
                <i class="bi bi-currency-dollar"></i>
                Pricing & Inventory
            </h4>

            <!-- Price -->
            <div class="form-group">
                <label for="price" class="form-label">
                    Price (MMK) <span class="required-mark">*</span>
                </label>

                <input
                    type="number"
                    name="price"
                    id="price"
                    class="item-input @error('price') is-invalid @enderror"
                    value="{{ old('price') }}"
                    placeholder="e.g. 5000"
                    min="0"
                    step="0.01"
                    required
                >

                <span class="field-hint">
                    Enter the price per item in MMK.
                </span>

                @error('price')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Initial Stock -->
            <div class="form-group">
                <label for="stock" class="form-label">
                    Initial Stock <span class="required-mark">*</span>
                </label>

                <input
                    type="number"
                    name="stock"
                    id="stock"
                    class="item-input @error('stock') is-invalid @enderror"
                    value="{{ old('stock', 0) }}"
                    placeholder="e.g. 100"
                    min="0"
                    step="1"
                    required
                >

                <span class="field-hint">
                    Enter the quantity currently available.
                </span>

                @error('stock')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Notice -->
            <div class="form-notice">
                <i class="bi bi-lightbulb"></i>
                <div>
                    <strong>Before saving</strong><br>
                    Please check the item name, price, and stock quantity.
                    The item will be added to your inventory after successful submission.
                </div>
            </div>

            <!-- Form actions -->
            <div class="form-actions">
                <a href="{{ route('items.index') }}" class="btn-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancel
                </a>

                <button type="submit" class="btn-create">
                    <i class="bi bi-plus-lg"></i>
                    Create Item
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
