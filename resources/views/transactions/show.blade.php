@extends('layouts.app')

@section('title', 'Transaction Detail')

@section('content')
<style>
    body {
        font-family: 'Arial', sans-serif; /* Gunakan font utama Blade */
    }
    .receipt {
        width: 450px; /* Lebar diperbesar agar cukup */
        border: 1px dashed #000;
        padding: 15px;
        font-family: 'Courier New', Courier, monospace;
        background: #fff;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .receipt-header, .receipt-footer {
        text-align: center;
        font-size: 14px;
    }
    .receipt-section {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .receipt-section div {
        display: flex;
        justify-content: space-between;
    }
    .receipt-section div span {
        display: inline-block;
    }
    .table-header {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        border-bottom: 1px solid #000;
        padding-bottom: 3px;
    }
    .table-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2px;
    }
    .receipt-footer p {
        margin: 3px 0;
    }/* Supaya Tombol Tidak Tercetak */
    @media print {
        .no-print {
            display: none;
        }
    }
</style>
<div class="container d-flex justify-content-center">
    <div class="receipt">
        <div class="receipt-header">
            <p>===================================</p>
            <p><strong>Es Teh Poci</strong></p>
            <p>Jln. Pahlawan No. 1</p>
            <p>Telp. 081234567890</p>
            <p>===================================</p>
        </div>
        <div class="receipt-section">
            <div>
                <span>Code</span>
                <span>: {{ $transaction->transaction_code }}</span>
            </div>
            <div>
                <span>Cashier</span>
                <span>: {{ Auth::user()->full_name ?? 'Guest' }}</span>
            </div>
            <div>
                <span>Date&Time</span>
                <td>: {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i') }}</td>
            </div>
        </div>
        <hr>
        <div class="receipt-section">
            <div class="table-header">
                <span>Product</span>
                <span>Qty</span>
                <span>Subtotal</span>
            </div>
            @foreach ($transaction->details as $detail)
                <div class="table-row">
                    <span>{{ $detail->product_name }}</span>
                    <span>{{ $detail->quantity }}</span>
                    <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
        <hr>
        <div class="receipt-section">
            <div>
                <span><strong>Price Total</strong></span>
                <span>: Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div>
                <span><strong>Paid</strong></span>
                <span>: Rp {{ number_format($transaction->paid, 0, ',', '.') }}</span>
            </div>
            <div>
                <span><strong>Change</strong></span>
                <span>: Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
        </div>
        <hr>
        <div class="receipt-footer">
            <p>-----------------------------------</p>
            <p><strong>TERIMA KASIH</strong></p>
            <p>Atas Kunjungan Anda</p>
            <p>-----------------------------------</p>
        </div>
    </div>
    <!-- Tombol Back dan Print -->
    <div class="mt-3 no-print">
        <a href="{{ route('transactions.history') }}" class="btn btn-secondary">Kembali</a>
        <button class="btn btn-primary" onclick="window.print()">Print</button>
    </div>
</div>
@endsection
