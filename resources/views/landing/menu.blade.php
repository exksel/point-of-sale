@extends('layouts.landing')

@section('title', 'Menu')

@section('content')
<style>
    .menu-section {
        text-align: center;
        padding: 50px 10px; /* Kurangi jarak kiri-kanan */
    }

    .menu-section h2 {
        font-family: 'Great Vibes', cursive;
        font-size: 36px;
        margin-bottom: 30px;
    }

    /* Grid Layout untuk 4 kolom per baris */
    .menu-items {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 kolom */
        gap: 25px; /* Jarak antar card lebih seimbang */
        justify-items: center;
    }

    .menu-item {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%; /* Pastikan proporsional */
        max-width: 250px; /* Batas maksimal */
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    /* Efek Hover (Timbul) */
    .menu-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Atur Ukuran Gambar Agar Konsisten */
    .menu-item img {
        width: 100%;
        height: 200px; /* Tetap proporsional */
        object-fit: cover;
    }

    /* Styling Informasi Produk */
    .item-info {
        flex-grow: 1;
        padding: 15px;
        background-color: #343a40;
        color: #fff;
        text-align: left;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 150px; /* Hindari tinggi card tidak seragam */
    }

    .item-info h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .item-info p {
        font-size: 14px;
        flex-grow: 1; /* Biar isi selalu proporsional */
    }

    .price {
        font-size: 16px;
        font-weight: bold;
    }

    .cart-btn {
        background-color: #ffc107;
        color: #000;
        border: none;
        padding: 8px;
        border-radius: 50%;
        cursor: pointer;
        float: right;
    }
</style>

<div class="menu-section">
    <h2>Our Menu</h2>

    <!-- Daftar Produk -->
    <div class="menu-items">
        @foreach ($products as $product)
            <div class="menu-item">
                @php
                    // Path gambar berdasarkan ID produk
                    $imagePath = asset('images/' . $product->id . '.jpg');
                    // Jika gambar tidak tersedia, gunakan placeholder
                    $defaultImage = 'https://placehold.co/1024x1024';
                @endphp
                
                <img src="{{ $imagePath }}" onerror="this.onerror=null;this.src='{{ $defaultImage }}';" alt="{{ $product->name }}">
                
                <div class="item-info">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 80) }}</p> <!-- Batasi deskripsi agar rapi -->
                    <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <button class="cart-btn"><i class="fas fa-shopping-cart"></i></button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
