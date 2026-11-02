<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item | Order System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f0ff, #faf8ff);
            font-family: Arial, sans-serif;
            color: #17152f;
        }
        .page-wrapper {
            max-width: 750px;
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
        .form-label {
            font-weight: 600;
            font-size: 14px;
        }
        .form-control {
            min-height: 48px;
            border: 1px solid #ded4f8;
            border-radius: 10px;
        }
        textarea.form-control {
            min-height: 120px;
        }
        .form-control:focus {
            border-color: #8248ed;
            box-shadow: 0 0 0 4px rgba(130, 72, 237, .12);
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
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="content-card">
        <div class="card-heading">
            <h3 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Item</h3>
            <p class="mb-0 mt-2">Update your item information</p>
        </div>

        <div class="card-body">
            <form action="{{ route('items.update', $item->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $item->name) }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                    >{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
 
                {{-- Item Image --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Item Image</label>

                    {{-- Show current image --}}
                    @if ($item->image && file_exists(public_path('storage/' . $item->image)))
                        <div class="mb-3">
                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->name }}"
                                style="width: 150px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #ded4f8;"
                            >
                        </div>
                    @else
                        <p class="text-muted small">No image uploaded yet.</p>
                    @endif

                    {{-- Upload a new image --}}
                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control @error('image') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="text-muted d-block mt-2">
                        Select a new image only if you want to replace the current image.
                        Supported formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                    </small>

                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                                
                <div class="mb-3">
                    <label for="price" class="form-label">Price (MMK)</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price', $item->price) }}"
                        min="0"
                        step="0.01"
                        required
                    >
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="stock" class="form-label">Stock Quantity</label>
                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        class="form-control @error('stock') is-invalid @enderror"
                        value="{{ old('stock', $item->stock) }}"
                        min="0"
                        required
                    >
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-purple">
                        <i class="bi bi-check-circle me-1"></i> Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
