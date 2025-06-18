@extends('layouts.app')

@section('title', 'Cashier')

@section('content')

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
        max-height: 420px; /* Sesuaikan tinggi berdasarkan desain */
        overflow-y: auto;  /* Aktifkan scroll jika lebih dari 10 produk */
    }
    /* Membuat daftar cart maksimal menampilkan 4 item sebelum scroll */
    .cart-list {
        max-height: 195px; /* Sesuaikan tinggi berdasarkan desain */
        overflow-y: auto;  /* Aktifkan scroll jika lebih dari 4 item */
    }
    .stock-icon-cell,
    .stock-number-cell {
        border: none;
        padding: 0;
        font-size: 15px;
        vertical-align: middle;
    }

    .stock-icon-cell {
        padding-right: 2px;
        text-align: right;
        white-space: nowrap;
    }

    .stock-number-cell {
        padding-left: 2px;
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .stock-icon-cell,
        .stock-number-cell {
            font-size: 13px;
        }
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
                                        <td class="stock-icon-cell">
                                            <i class="bi bi-box-seam"></i> :
                                        </td>
                                        <td class="stock-number-cell {{ $product->stock < 10 ? 'text-danger' : 'text-primary' }}">
                                            {{ $product->stock }}
                                        </td>

                                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm add-to-cart" 
                                                data-id="{{ $product->id }}" 
                                                data-name="{{ $product->name }}"
                                                data-stock="{{ $product->stock }}"
                                                data-price="{{ $product->price }}">
                                                <i class="bi bi-cart-plus"></i>
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
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label><i class="bi bi-cash-coin"></i> Price Total</label>
                                    <input type="text" id="totalPrice" class="form-control text-center bg-light" value="Rp 0" readonly>
                                </div>
                        
                                <!-- Input Nominal Bayar -->
                                <div class="col-md-6 mb-3">
                                    <label><i class="bi bi-wallet2"></i> Paid</label>
                                    <input type="number" name="paid" id="paidAmount" class="form-control" 
                                    required placeholder="Input paid amount" 
                                    min="1" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                            </div>
                        
                            <!-- Input Kembalian -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label><i class="bi bi-cash-stack"></i> Change</label>
                                    <input type="text" id="changeAmount" class="form-control text-center bg-light" value="Rp 0" readonly>
                                </div>

                            <!-- Input Payment Type -->
                                <div class="col-md-6 mb-3">
                                    <label><i class="bi bi-credit-card"></i> Payment Type</label>
                                    <select name="payment_type" id="payment_type" class="form-control" required>
                                        <option value="" selected disabled>Choose payment method</option>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Input Email -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label><i class="bi bi-envelope-at"></i> Email</label>
                                    <input type="email" name="email" id="emailInput" class="form-control" placeholder="Input customer email (Optional)">
                                </div>
                            </div>            
                            
                            

                            <!-- Tombol Submit -->
                            <button type="button" id="submitBtn" class="btn btn-success">Submit</button>
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

    // **[1] Matikan tombol otomatis jika stok awal = 0**
    document.querySelectorAll(".add-to-cart").forEach(button => {
        let stock = parseInt(button.dataset.stock);
        if (stock <= 0) {
            button.disabled = true;
        }
    });

    // Menambahkan produk ke cart
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.dataset.id;
            let name = this.dataset.name;
            let price = parseFloat(this.dataset.price);
            let stock = parseInt(this.dataset.stock);
            
            if (stock <= 0) {
                Swal.fire({ icon: "error", title: "Stok Habis!", text: "Stok barang ini sudah habis." });
                return;
            }

            let existingItem = cart.find(item => item.id === id);
            if (!existingItem) {
                cart.push({ id, name, price, quantity: 1, stock });
                
                // Kurangi stok tampilan
                let stockCell = this.closest("tr").querySelector("td:nth-child(3)");
                stockCell.textContent = stock - 1;
                this.dataset.stock = stock - 1;

                // Disable tombol setelah menambahkan ke keranjang
                this.disabled = true;
            }

            updateCart();
        });
    });

    function updateCart() {
        let tbody = document.querySelector("#subtotalTable tbody");
        let form = document.getElementById("transactionForm");
        tbody.innerHTML = "";
        form.querySelectorAll(".product-input").forEach(input => input.remove());

        cart.forEach((item, index) => {
            let subtotal = item.price * item.quantity;
            let row = document.createElement("tr");
            row.innerHTML = `
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
            `;
            tbody.appendChild(row);

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
        updateChange();
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

        let product = cart[index];
        let productRow = document.querySelector(`button[data-id='${product.id}']`).closest("tr");
        let stockCell = productRow.querySelector("td:nth-child(3)");
        let addToCartButton = document.querySelector(`button[data-id='${product.id}']`);

        let currentStock = parseInt(stockCell.textContent);
        
        if (event.target.classList.contains("increment")) {
            if (product.quantity < product.stock) {
                product.quantity++;
                stockCell.textContent = currentStock - 1;
                addToCartButton.dataset.stock = currentStock - 1;
            } else {
                Swal.fire({ icon: "error", title: "Stok Tidak Cukup!", text: "Jumlah melebihi stok tersedia." });
                event.target.disabled = true;
            }
        } else if (event.target.classList.contains("decrement")) {
            if (product.quantity > 1) {
                product.quantity--;
                stockCell.textContent = currentStock + 1;
                addToCartButton.dataset.stock = currentStock + 1;
            } else {
                stockCell.textContent = currentStock + product.quantity;
                addToCartButton.dataset.stock = currentStock + product.quantity;
                cart.splice(index, 1);
                addToCartButton.disabled = false;
            }
        } else if (event.target.classList.contains("remove-item")) {
            stockCell.textContent = currentStock + product.quantity;
            addToCartButton.dataset.stock = currentStock + product.quantity;
            cart.splice(index, 1);
            addToCartButton.disabled = false;
        }

        updateCart();
    });

    // Update kembalian saat input bayar berubah
    document.getElementById("paidAmount").addEventListener("input", updateChange);

    // Konfirmasi transaksi sebelum submit
    document.getElementById("submitBtn").addEventListener("click", function (event) {
        event.preventDefault();

        let totalHarga = parseFloat(document.getElementById("totalPrice").value.replace(/[^\d]/g, '')) || 0;
        let nominalBayar = parseFloat(document.getElementById("paidAmount").value.replace(/[^\d]/g, '')) || 0;
        let email = document.getElementById("emailInput").value.trim();
        let paymentType = document.getElementById("payment_type").value;

        if (totalHarga === 0) {
            Swal.fire({ icon: "error", title: "Failed!", text: "Tidak ada produk yang dibeli." });
            return;
        }
        if (nominalBayar === 0) {
            Swal.fire({ icon: "error", title: "Failed!", text: "Masukkan nominal bayar." });
            return;
        }
        if (nominalBayar < totalHarga) {
            Swal.fire({ icon: "error", title: "Failed!", text: "Nominal bayar kurang dari total harga." });
            return;
        }
            if (!paymentType) {
            Swal.fire({ icon: "error", title: "Failed!", text: "Pilih tipe pembayaran." });
            return;
        }

    // Konfirmasi akhir sebelum submit form
    Swal.fire({
        title: "Konfirmasi Pembayaran",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, lakukan pembayaran!",
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
