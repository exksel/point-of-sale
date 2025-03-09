@extends('layouts.app')

@section('title', 'Cashier')

@section('content')

<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        height: 100%;
        margin: 0;
        overflow: hidden;
    }
    .card {
        margin: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .table th {
        background-color: #007bff;
        color: white;
    }
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-sm {
        margin-right: 5px;
    }
    .transparent-table td {
        border: none;
    }
    .product-list {
        max-height: 450px; /* Sesuaikan tinggi berdasarkan desain */
        overflow-y: auto;  /* Aktifkan scroll jika lebih dari 10 produk */
    }

    /* Membuat daftar cart maksimal menampilkan 4 item sebelum scroll */
    .cart-list {
        max-height: 200px; /* Sesuaikan tinggi berdasarkan desain */
        overflow-y: auto;  /* Aktifkan scroll jika lebih dari 4 item */
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="header-container">
                <h6 class="m-0 font-weight-bold text-primary">Cashier</h6>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                @csrf
                <div class="row">
                    <!-- Produk -->
                    <div class="col-md-6">
                        <h5 class="text-center text-primary"><i class="bi bi-box-fill"></i> Product</h5>
                        <hr>
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control w-50 mx-auto" placeholder="Cari produk..." style="margin-bottom: 10px;">
                        </div>
                        <div class="table-responsive product-list">
                            <table class="table table-bordered" id="productTable">
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm add-to-cart" 
                                                data-id="{{ $product->id }}" 
                                                data-name="{{ $product->name }}" 
                                                data-price="{{ $product->price }}">
                                                <i class="bi bi-cart-plus"></i> Add
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Keranjang (Subtotal) -->
                    <div class="col-md-6">
                        <h5 class="text-center text-primary"><i class="bi bi-cart-fill"></i> Cart</h5>
                        <hr>
                        <div class="mb-3 cart-list">
                            <table class="table table-striped table-bordered text-center" id="subtotalTable">
                                <thead class="table-success">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <form id="transactionForm" action="{{ route('transactions.store') }}" method="POST">
                            @csrf
                            <!-- Input Total Harga -->
                            <div class="mb-3">
                                <label><i class="bi bi-cash-coin"></i> Price Total</label>
                                <input type="text" id="totalPrice" class="form-control text-center bg-light" value="Rp 0" readonly>
                            </div>
                        
                            <!-- Input Nominal Bayar -->
                            <div class="mb-3">
                                <label><i class="bi bi-wallet2"></i> Paid</label>
                                <input type="number" name="paid" id="paidAmount" class="form-control" 
                                required placeholder="Input paid amount" 
                                min="1" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        
                            <!-- Input Kembalian -->
                            <div class="mb-3">
                                <label><i class="bi bi-cash-stack"></i> Change</label>
                                <input type="text" id="changeAmount" class="form-control text-center bg-light" value="Rp 0" readonly>
                            </div>
                        
                            <!-- Tombol Submit -->
                            <button type="button" id="submitBtn" class="btn btn-primary">Payment</button>
                        </form>                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let cart = [];
    
        // Menambahkan produk ke cart
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", function () {
                let id = this.dataset.id;
                let name = this.dataset.name;
                let price = parseFloat(this.dataset.price);
                let existingItem = cart.find(item => item.id === id);
    
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({ id, name, price, quantity: 1 });
                }
    
                updateCart();
            });
        });
    
        function updateCart() {
            let tbody = document.querySelector("#subtotalTable tbody");
            let form = document.getElementById("transactionForm");
            tbody.innerHTML = "";
            form.querySelectorAll(".product-input").forEach(input => input.remove()); // Hapus input lama
    
            cart.forEach((item, index) => {
                let subtotal = item.price * item.quantity;
                let row = `
                    <tr>
                        <td>${item.name}</td>
                        <td>Rp ${new Intl.NumberFormat("id-ID").format(item.price)}</td>
                        <td>
                            <button class="btn btn-sm btn-warning decrement" data-index="${index}">-</button>
                            <span class="mx-2">${item.quantity}</span>
                            <button class="btn btn-sm btn-success increment" data-index="${index}">+</button>
                        </td>
                        <td>Rp ${new Intl.NumberFormat("id-ID").format(subtotal)}</td>
                        <td>
                            <button class="btn btn-sm btn-danger remove-item" data-index="${index}">X</button>
                        </td>
                    </tr>`;
                tbody.innerHTML += row;
    
                // Input hidden untuk dikirim ke backend
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = `products[${item.id}][quantity]`;
                input.value = item.quantity;
                input.classList.add("product-input");
                form.appendChild(input);
            });
    
            updateTotalPrice();
        }
    
        function updateTotalPrice() {
            let total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            document.getElementById("totalPrice").value = `Rp ${new Intl.NumberFormat("id-ID").format(total)}`;
            updateChange(); // Perbarui kembalian setelah total berubah
        }
    
        function updateChange() {
            let totalHarga = parseFloat(document.getElementById("totalPrice").value.replace(/[^\d]/g, '')) || 0;
            let nominalBayar = parseFloat(document.getElementById("paidAmount").value.replace(/[^\d]/g, '')) || 0;
            let kembalian = nominalBayar - totalHarga;
            if (totalHarga === 0 || nominalBayar < totalHarga) kembalian = 0;
    
            document.getElementById("changeAmount").value = `Rp ${new Intl.NumberFormat("id-ID").format(kembalian)}`;
        }
    
        // Event Delegation untuk +/- dan Hapus
        document.querySelector("#subtotalTable").addEventListener("click", function (event) {
            let index = event.target.dataset.index;
            if (index === undefined) return;
    
            if (event.target.classList.contains("increment")) {
                cart[index].quantity++;
            } else if (event.target.classList.contains("decrement")) {
                cart[index].quantity > 1 ? cart[index].quantity-- : cart.splice(index, 1);
            } else if (event.target.classList.contains("remove-item")) {
                cart.splice(index, 1);
            }
    
            updateCart();
        });
    
        // Event listener untuk update kembalian secara langsung
        document.getElementById("paidAmount").addEventListener("input", updateChange);
    
        // Konfirmasi transaksi sebelum submit
        document.getElementById("submitBtn").addEventListener("click", function (event) {
            event.preventDefault();
    
            let totalHarga = parseFloat(document.getElementById("totalPrice").value.replace(/[^\d]/g, '')) || 0;
            let nominalBayar = parseFloat(document.getElementById("paidAmount").value.replace(/[^\d]/g, '')) || 0;
    
            if (totalHarga === 0) {
                Swal.fire({ icon: "error", title: "Gagal!", text: "Tidak ada produk yang dibeli." });
                return;
            }
            if (nominalBayar === 0) {
                Swal.fire({ icon: "error", title: "Gagal!", text: "Masukkan nominal bayar." });
                return;
            }
            if (nominalBayar < totalHarga) {
                Swal.fire({ icon: "error", title: "Gagal!", text: "Nominal bayar kurang dari total harga." });
                return;
            }
    
            Swal.fire({
                title: "Konfirmasi Transaksi",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, lakukan transaksi!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("transactionForm").submit();
                }
            });
        });

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

        // Reset saat refresh
        window.onload = function () {
            document.getElementById("transactionForm").reset();
            document.getElementById("paidAmount").value = "";
            document.getElementById("totalPrice").value = "Rp 0";
            document.getElementById("changeAmount").value = "Rp 0";
        };
    });
    </script>    
@endsection
