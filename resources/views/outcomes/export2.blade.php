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
            <!-- Form Export -->
            <form action="{{ route('outcomes.export2') }}" method="POST" class="mb-3" id="exportForm">
                @csrf

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Export</button>
                    <a href="{{ route('outcomes.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

            <!-- Form Preview -->
            <form action="{{ route('outcomes.preview2') }}" method="POST" id="previewForm">
                @csrf
                <input type="hidden" name="start_date" id="preview_start_date">
                <input type="hidden" name="end_date" id="preview_end_date">
                <button type="submit" class="btn btn-primary"> Preview</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert & Validasi -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startInput = document.getElementById('start_date');
        const endInput = document.getElementById('end_date');
        const previewStart = document.getElementById('preview_start_date');
        const previewEnd = document.getElementById('preview_end_date');
        const previewForm = document.getElementById('previewForm');
        const exportForm = document.getElementById('exportForm');

        // Validasi end date minimum
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

        // SweetAlert validasi untuk Preview
        previewForm.addEventListener('submit', function (e) {
            if (!startInput.value || !endInput.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal belum lengkap',
                    text: 'Silakan isi Start Date dan End Date terlebih dahulu!',
                    confirmButtonColor: '#007bff',
                });
            } else {
                previewStart.value = startInput.value;
                previewEnd.value = endInput.value;
            }
        });

        // SweetAlert validasi untuk Export
        exportForm.addEventListener('submit', function (e) {
            if (!startInput.value || !endInput.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal belum lengkap',
                    text: 'Silakan isi Start Date dan End Date terlebih dahulu!',
                    confirmButtonColor: '#007bff',
                });
            }
        });
    });
</script>

@endsection
