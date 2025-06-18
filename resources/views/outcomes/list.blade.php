@extends('layouts.app')

@section('title', 'Expenses')

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
    }
    .btn-sm {
        margin-right: 5px;
    }
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="header-container">
                <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('outcomes.addexpense') }}" class="btn btn-primary btn-sm">Add Expense</a>
                    <a href="{{ route('outcomes.export2.form') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Expense Name</th>
                            <th>Quantity</th>
                            <th>Note</th>
                            <th>Total Expense</th>
                            <th>Date&Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $index => $expense)
                        <tr>
                            <td>{{ $expense->expense_id }}</td>
                            <td>{{ $expense->expense_name }}</td>
                            <td>{{ $expense->quantity }}</td>
                            <td>{{ $expense->note ?? '-' }}</td>
                            <td>Rp {{ number_format($expense->expense_total, 0, ',', '.') }}</td>
                            <td>{{ date(('d-m-Y H:i'), strtotime($expense->expense_date)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Pagination
document.addEventListener("DOMContentLoaded", function () {
    const datatablesSimple = document.getElementById("datatablesSimple");
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            perPage: 10,
            perPageSelect: [10, 15, 25, 50],
        });
    }
});
</script>

@endsection
