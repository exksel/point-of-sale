@extends('layouts.app')
@section('title', 'Import Products')
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
            <h6 class="m-0 font-weight-bold text-primary">Import Products</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Upload Excel File</label>
                    <input type="file" class="form-control" name="file" required accept=".xls,.xlsx">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Import</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection
