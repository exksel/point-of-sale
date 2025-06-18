@extends('layouts.app')
@section('title', 'Export Expense')
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Export Setting</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('outcomes.export2') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Export</button>
                <a href="{{ route('outcomes.list') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startInput = document.querySelector('input[name="start_date"]');
        const endInput = document.querySelector('input[name="end_date"]');

        startInput.addEventListener('change', function () {
            endInput.min = this.value;
        });

        endInput.addEventListener('change', function () {
            if (this.value < startInput.value) {
                this.setCustomValidity('End date cannot be before start date');
            } else {
                this.setCustomValidity('');
            }
        });
    });
</script>

@endsection
