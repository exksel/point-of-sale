@extends('layouts.app')
@section('title', 'Edit Product')
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
    .preview-img {
        max-width: 100px;
        margin-top: 10px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                </div>

                <!-- Input untuk upload gambar -->
                <div class="mb-3">
                    <label class="form-label">Product Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(event)">
                    
                    <!-- Tampilkan gambar lama jika ada -->
                    @if ($product->image)
                        <div>
                            <img id="preview" src="{{ asset($product->image) }}" class="preview-img" alt="Product Image">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" required>{{ $product->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" value="{{ $product->stock ?? 0 }}" required min="0"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" value="{{ $product->price }}" required 
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                </div>

                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview');
            if (preview) {
                preview.src = reader.result;
            }
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Menangani klik tombol 'Save' dengan konfirmasi menggunakan SweetAlert2
    document.getElementById('submitBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to save these changes?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik 'Yes, save it!', kirim form
                document.getElementById('editProductForm').submit();
            }
        });
    });
</script>
@endsection
