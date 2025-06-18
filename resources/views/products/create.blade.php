@extends('layouts.app')
@section('title', 'Add Product')
@section('content')

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

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" required min="0"
                    inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>                
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" required oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection