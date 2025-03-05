@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
    <!-- Bootstrap CSS & SB Admin Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            margin: 20px;
        }
        .btn-sm {
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" required>{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" value="{{ $product->price }}" required oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection