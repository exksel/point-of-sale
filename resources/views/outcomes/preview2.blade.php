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
                    <h6 class="m-0 font-weight-bold text-primary">Expense Preview</h6>
                    <small class="text-muted">
                        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
                    </small>
                </div>
                <a href="{{ route('outcomes.export2.form') }}" class="btn btn-secondary btn-sm">
                    Back
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(count($expenses) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Expense ID</th>
                                <th>Expense Name</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Note</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $i => $expense)
                                @php
                                    $isEvenRow = $i % 2 === 0;
                                    $rowColor = $isEvenRow ? '#f0f0f0' : '#ffffff';
                                @endphp
                                <tr style="background-color: {{ $rowColor }};">
                                    <td class="text-center">{{ $expense->expense_id }}</td>
                                    <td class="text-center">{{ $expense->expense_name }}</td>
                                    <td class="text-center">{{ $expense->quantity }}</td>
                                    <td class="text-center">Rp {{ number_format($expense->expense_total, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $expense->note ?? '-' }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total Expense:</td>
                                <td class="fw-bold text-primary text-center">
                                    Rp {{ number_format($expenses->sum('expense_total'), 0, ',', '.') }}
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <p class="text-muted">No expenses found in the selected range.</p>
            @endif
        </div>
    </div>
</div>

@endsection
