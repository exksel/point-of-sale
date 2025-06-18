@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .card {
        margin: 20px;
    }
    .btn-sm {
        margin-right: 5px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Expense</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Expense Name</label>
                    <input type="text" class="form-control" name="expense_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity" required min="1"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
                <div class="mb-3">
                    <label class="form-label">Note</label>
                    <textarea class="form-control" name="note"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Expense</label>
                    <input type="number" class="form-control" name="expense_total" required min="0" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <a href="{{ route('outcomes.list') }}" class="btn btn-secondary btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
