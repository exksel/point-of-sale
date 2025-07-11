<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .receipt {
            width: 450px;
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
        .table-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            margin-bottom: 5px;
        }
        .table-header span {
            width: 33%;
            text-align: center;
        }
        .table-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .table-row span {
            width: 33%;
            text-align: center;
        }
        .receipt-footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="receipt">
            <div class="receipt-header">
                <p>===================================</p>
                <p><strong>EsTeh Desa</strong></p>
                <p>Ds. Nguntoronadi, Magetan</p>
                <p> {{ Auth::user()->phone_number ?? '' }} </p>
                <p>===================================</p>
            </div>
            <div class="receipt-section">
                <div>
                    <span>Code</span>
                    <span>: {{ $transaction->transaction_code }}</span>
                </div>
                <div>
                    <span>Cust Email</span>
                    <span>: {{ $transaction->email }}</span>
                </div>
                <div>
                    <span>Cashier</span>
                    <span>: {{ Auth::user()->full_name ?? 'Guest' }}</span>
                </div>
                <div>
                    <span>Date & Time</span>
                    <span>: {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i') }}</span>
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
                <div>
                    <span><strong>Payment Type</strong></span>
                    <span>: {{ ucfirst($transaction->payment_type) }}</span>
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
    </div>
</body>
</html>
