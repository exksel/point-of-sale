@extends('layouts.app')
@section('title', 'Export Setting')
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
            <!-- Form Export -->
            <form action="{{ route('transactions.export') }}" method="POST" class="mb-3" id="exportForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Export</button>
                    <a href="{{ route('transactions.history') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

            <!-- Form View Preview -->
            <form action="{{ route('transactions.export.preview') }}" method="POST" id="previewForm">
                @csrf
                <input type="hidden" name="start_date" id="view_start_date">
                <input type="hidden" name="end_date" id="view_end_date">
                <button type="submit" class="btn btn-primary">Preview</button>
            </form>
        </div>
    </div>
</div>

<script>
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const viewStartInput = document.getElementById('view_start_date');
    const viewEndInput = document.getElementById('view_end_date');

    startDateInput.addEventListener('change', function () {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = '';
        }
        viewStartInput.value = this.value;
    });

    endDateInput.addEventListener('change', function () {
        viewEndInput.value = this.value;
    });


    // Sweetalert Preview
    exportForm.addEventListener('submit', function (e) {
        if (!startDateInput.value || !endDateInput.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Tanggal belum lengkap',
                text: 'Silakan isi Start Date dan End Date terlebih dahulu!',
                confirmButtonColor: '#007bff',
            });
        }
    });

    // Sweetalert Preview
    const previewForm = document.getElementById('previewForm');

    previewForm.addEventListener('submit', function (e) {
        const startVal = startDateInput.value;
        const endVal = endDateInput.value;

        viewStartInput.value = startVal;
        viewEndInput.value = endVal;

        if (!startVal || !endVal) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Tanggal belum lengkap',
                text: 'Silakan isi Start Date dan End Date terlebih dahulu!',
                confirmButtonColor: '#007bff',
            });
        }
    });
</script>
@endsection
