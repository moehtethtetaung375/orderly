
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details | Order System</title>

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
            max-width: 900px;
            margin: 50px auto;
            padding: 0 20px;
        }
        .content-card {
            background: #fff;
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
        .detail-box {
            padding: 16px;
            border: 1px solid #eee7ff;
            border-radius: 12px;
            background: #fdfcff;
            height: 100%;
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
        <div class="card-heading d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="mb-0"><i class="bi bi-box-seam me-2"></i>Item Details</h3>
            <span class="badge bg-light text-dark">ID: {{ $item->id }}</span>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Item Name</div>
                        <div class="detail-value">{{ $item->name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Price</div>
                        <div class="detail-value">{{ number_format($item->price, 2) }} MMK</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Stock</div>
                        <div class="detail-value">{{ $item->stock }}</div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="detail-box">
                        <div class="detail-label">Description</div>
                        <div class="detail-value" style="font-weight: normal;">
                            {{ $item->description ?: 'No description available.' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Items
                </a>

                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-purple">
                    <i class="bi bi-pencil-square me-1"></i> Edit Item
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
