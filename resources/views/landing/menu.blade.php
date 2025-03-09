@extends('layouts.landing')

@section('title', 'Menu')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: url('{{ asset("images/backhome.jpg") }}') no-repeat center center fixed;
        background-size: cover;
    }

    .menu-section {
        text-align: center;
        padding: 60px 20px;
    }

    .menu-section h2 {
        font-family: 'Great Vibes', cursive;
        font-size: 48px;
        color: #FF4500;
        margin-bottom: 40px;
    }

    /* Grid Layout */
    .menu-items {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        justify-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .menu-item {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        max-width: 280px;
    }

    /* Efek Hover */
    .menu-item:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    /* Styling Gambar */
    .menu-item img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }

    .item-info {
        padding: 20px;
        background: #fff;
        text-align: left;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .item-info h3 {
        font-size: 20px;
        color: #333;
        font-weight: bold;
    }

    .item-info p {
        font-size: 14px;
        color: #666;
        margin: 10px 0;
        flex-grow: 1;
    }

    .price {
        font-size: 18px;
        font-weight: bold;
        color: #28a745;
    }

    .cart-btn {
        background: linear-gradient(45deg, #FF4500, #FFA500);
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 50px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-weight: bold;
        width: 100%;
    }
</style>

<div class="menu-section">
    <h2>Our Menu</h2>

    <div class="menu-items">
        @foreach ($products as $product)
            <div class="menu-item">
                @php
                    $imagePath = asset('images/' . $product->id . '.jpg');
                    $defaultImage = 'https://placehold.co/1024x1024';
                @endphp
                
                <img src="{{ $imagePath }}" onerror="this.onerror=null;this.src='{{ $defaultImage }}';" alt="{{ $product->name }}">
                
                <div class="item-info">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 80) }}</p>
                    <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
