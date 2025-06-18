@extends('layouts.app')
@section('title', 'Export Transactions')
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
            <form action="{{ route('transactions.export.form') }}" method="POST">
                @csrf

                <!-- Start-End Date Fields Only -->
                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>


                <button type="submit" class="btn btn-success">Export</button>
                <a href="{{ route('transactions.history') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script>
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    startDateInput.addEventListener('change', function () {
        const selectedStart = this.value;

        // Atur min pada end_date agar tidak bisa mundur
        endDateInput.min = selectedStart;

        // Jika end date sudah dipilih tapi lebih kecil dari start date, kosongkan
        if (endDateInput.value && endDateInput.value < selectedStart) {
            endDateInput.value = '';
        }
    });
</script>
@endsection
