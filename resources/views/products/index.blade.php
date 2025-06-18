@extends('layouts.app')

@section('title', 'Products')

@section('content')


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .card {
        margin: 20px;
    }
    .table th {
        background-color: #007bff;
        color: white;
    }
    .btn-sm {
        margin-right: 5px;
    }
    .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    /* Ukuran gambar kecil */
    .product-img {
            width: 50px;  /* Sesuaikan ukuran */
            height: 50px; /* Sesuaikan ukuran */
            object-fit: cover; /* Agar gambar tetap rapi */
            border-radius: 5px; /* Opsional: buat gambar sedikit melengkung */
        }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="header-container">
                <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-boxes"></i> Add Product</a>
                    <a href="{{ route('products.import') }}" class="btn btn-success btn-sm"><i class="bi bi-box-arrow-up"></i> Import</a>
                    <a href="{{ route('products.export') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Export</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" class="product-img" alt="Product Image">
                                @else
                                    <span class="text-muted"><i class="bi bi-image"></i> Image</span>
                                @endif
                            </td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->stock ?? 0 }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $product->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
// Pagination
    document.addEventListener("DOMContentLoaded", function () {
    const datatablesSimple = document.getElementById("datatablesSimple");
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            perPage: 8, // Ubah default jumlah baris per halaman menjadi 5
            perPageSelect: [8, 15, 25, 50], // Opsi pilihan jumlah data per halaman
        });
    }
});

// Search
    document.getElementById("searchInput").addEventListener("keyup", function () {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll("#productTable tbody tr");

                rows.forEach(row => {
                    let productName = row.cells[0].textContent.toLowerCase(); // Nama produk
                    let productPrice = row.cells[1].textContent.toLowerCase().replace(/[^\d]/g, ''); // Harga produk tanpa karakter non-angka

                    if (productName.includes(filter) || productPrice.includes(filter)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });

    
//sweet alert delete
    function confirmDelete(productId) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + productId).submit();
            }
        });
    }
// Menampilkan notifikasi setelah penghapusan berhasil
    @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
        });
    @endif
</script>
@endsection