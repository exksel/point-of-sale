@extends('layouts.app')

@section('title', 'Detail')

@section('content')
<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Kode Transaksi</th>
            <td>{{ $transaction->transaction_code }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Bayar</th>
            <td>Rp {{ number_format($transaction->paid, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Kembalian</th>
            <td>Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Waktu Transaksi</th>
            <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <h3>Detail Product</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('transactions.history') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
