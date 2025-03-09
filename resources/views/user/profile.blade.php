@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .card {
        margin: 20px auto;
        max-width: 500px;
    }
    .btn-sm {
        margin-top: 10px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <script>
                    Swal.fire({
                        title: "Berhasil!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    Swal.fire({
                        title: "Gagal!",
                        text: "{{ session('error') }}",
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "OK"
                    });
                </script>
            @endif

            <form id="updateProfileForm" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                </div>            

                <div class="mb-3">
                    <label for="password" class="form-label">New Password (optional)</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                </div>

                <button type="button" class="btn btn-success btn-sm" onclick="confirmUpdate()">Save</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmUpdate() {
        let form = document.getElementById("updateProfileForm");
        let fullName = document.getElementById("full_name").value;
        let phoneNumber = document.getElementById("phone_number").value;
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        let originalFullName = "{{ $user->full_name }}";
        let originalPhoneNumber = "{{ $user->phone_number }}";
        let originalUsername = "{{ $user->username }}";

        // Cek jika tidak ada perubahan data
        if (
            fullName === originalFullName &&
            phoneNumber === originalPhoneNumber &&
            username === originalUsername &&  // Tambahkan pengecekan username
            password === ""
            ) {
            Swal.fire({
                title: "Gagal!",
                text: "Tidak ada perubahan yang dilakukan.",
                icon: "error",
                confirmButtonColor: "#d33",
                confirmButtonText: "OK"
            });
        } else {
            // Konfirmasi sebelum update
            Swal.fire({
                title: "Yakin ingin memperbarui profil?",
                text: "Data Anda akan diperbarui!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, perbarui!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    }
</script>

@endsection
