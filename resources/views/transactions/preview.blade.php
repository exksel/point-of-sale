@extends('layouts.app')

@section('title', 'Export Preview')

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
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-sm {
        margin-right: 5px;
    }

    h6 {
        margin: 0;
    }
    @media (max-width: 768px) {
        body {
            overflow-x: auto;
        }

        .container {
            min-width: 1200px; /* Atur sesuai lebar konten aslinya */
        }

        html {
            overflow-x: auto;
        }
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Export Preview</h6>
                    <small class="text-muted">
                        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
                    </small>
                </div>
                <a href="{{ route('transactions.export.form') }}" class="btn btn-secondary btn-sm">
                    Back
                </a>
            </div>
        </div>


        <div class="card-body">
            @if(count($transactions) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Cust Email</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Change</th>
                                <th>Payment</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $trxIndex = 0; @endphp
                            @foreach($transactions as $trx)
                                @php
                                    $isEvenTransaction = $trxIndex % 2 === 0;
                                    $rowColor = $isEvenTransaction ? '#f0f0f0' : '#ffffff';
                                @endphp

                                @foreach($trx->details as $i => $detail)
                                    <tr style="background-color: {{ $rowColor }};">
                                        <td class="text-center">{{ $i === 0 ? $trx->transaction_code : '' }}</td>
                                        <td class="text-center">{{ $i === 0 ? $trx->email : '' }}</td>
                                        <td class="text-center">{{ $detail->product_name ?? 'Unknown' }}</td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-center">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $i === 0 ? 'Rp ' . number_format($trx->total, 0, ',', '.') : '' }}</td>
                                        <td class="text-center">{{ $i === 0 ? 'Rp ' . number_format($trx->paid, 0, ',', '.') : '' }}</td>
                                        <td class="text-center">{{ $i === 0 ? 'Rp ' . number_format($trx->change, 0, ',', '.') : '' }}</td>
                                        <td class="text-center">{{ $i === 0 ? ucfirst($trx->payment_type) : '' }}</td>
                                        <td class="text-center">{{ $i === 0 ? \Carbon\Carbon::parse($trx->transaction_date)->format('d-m-Y H:i') : '' }}</td>
                                    </tr>
                                @endforeach

                                @php $trxIndex++; @endphp
                            @endforeach

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Total Income:</td>
                                <td colspan="5" class="fw-bold text-primary">
                                    Rp {{ number_format($transactions->sum('total'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <p class="text-muted">No transactions found in the selected range.</p>
            @endif
        </div>
    </div>
</div>
@endsection
