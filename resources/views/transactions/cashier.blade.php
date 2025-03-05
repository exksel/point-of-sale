@extends('layouts.app')

@section('title', 'Cashier')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .btn-sm {
        margin-right: 5px;
    }
</style>
<div class="container">
    <h2>Kasir</h2>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <input type="number" name="products[{{ $product->id }}][quantity]" value="0" min="0">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <label>Nominal Bayar</label>
        <input type="number" name="paid" required>

        <button type="submit" class="btn btn-primary">Bayar</button>
    </form>
</div>
@endsection
