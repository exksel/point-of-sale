@extends('layouts.app')

@section('title', 'History')

@section('content')

<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables CSS & JS -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>

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
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-sm {
        margin-right: 5px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="header-container">
                <h6 class="m-0 font-weight-bold text-primary">Transaction List</h6>
                <a href="{{ url('/transactions/export-excel') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Transaction Code</th>
                            <th>Price Total</th>
                            <th>Paid</th>
                            <th>Change</th>
                            <th>Date&Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_code }}</td>
                            <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaction->paid, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('transaction.show', $transaction->transaction_code) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
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
    // Pagination dan Search dengan DataTables
    document.addEventListener("DOMContentLoaded", function () {
        const datatablesSimple = document.getElementById("datatablesSimple");
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple, {
                perPage: 8,
                perPageSelect: [8, 15, 25, 50],
            });
        }
    });
</script>

@endsection