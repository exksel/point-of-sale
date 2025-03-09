@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-custom {
        border: none;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #007bff;
    }

    .card-icon {
        font-size: 40px;
        color: #007bff;
    }

    .card-body {
        text-align: center;
    }

    .welcome-container {
        text-align: center;
    }

    .dashboard-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .chart-container {
        margin-top: 30px;
        padding: 15px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        height: 50%;
    }

    .chart-container canvas {
        height: 50%;

    }

</style>

<div class="container mt-4">
    <div class="header-container">
        <h6 class="m-0 font-weight-bold text-primary">Dashboard</h6>
    </div>
    <div class="header-container">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="bi bi-person-fill"></i> Hi, {{ Auth::user()->full_name ?? 'Guest' }}
        </h6>
        <p id="date-time" class="m-0 font-weight-bold text-primary"></p>
    </div>
    

    <div class="dashboard-container">
        <div class="card card-custom p-3">
            <div class="card-body">
                <i class="bi bi-people card-icon"></i>
                <h5 class="card-title">Admin</h5>
                <strong>{{ $totalUser }}</strong>
            </div>
        </div>

        <div class="card card-custom p-3">
            <div class="card-body">
                <i class="bi bi-box card-icon"></i>
                <h5 class="card-title">Products</h5>
                <strong>{{ $jumlahProduk }}</strong>
            </div>
        </div>

        <div class="card card-custom p-3">
            <div class="card-body">
                <i class="bi bi-cart-check card-icon"></i>
                <h5 class="card-title">Transaction</h5>
                <strong>{{ $jumlahTransaksi }}</strong>
            </div>
        </div>

        <div class="card card-custom p-3">
            <div class="card-body">
                <i class="bi bi-cash-stack card-icon"></i>
                <h5 class="card-title">Income</h5>
                <strong>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <!-- Produk yang Sering Dibeli -->
    <div class="chart-container mt-4">
        <h5 class="text-primary">Top 5 Best Selling Product</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total Selling</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produkSeringDibeli as $produk)
                <tr>
                    <td>{{ $produk->product->name }}</td>
                    <td>{{ $produk->total_qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Diagram Pendapatan per Bulan -->
    <div class="chart-container mt-4">
        <h5 class="text-primary">Income</h5>
        <canvas id="chartPendapatan"></canvas>
    </div>
</div>

<!-- Spacer -->
<div style="height: 20px;"></div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Waktu
    function updateDateTime() {
        const now = new Date();
        
        const day = now.getDate().toString().padStart(2, '0');
        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const month = monthNames[now.getMonth()];
        const year = now.getFullYear();
        
        const hour = now.getHours().toString().padStart(2, '0');
        const minute = now.getMinutes().toString().padStart(2, '0');
        const second = now.getSeconds().toString().padStart(2, '0');
        
        const dateTimeString = `${day} ${month} ${year} | ${hour}:${minute}:${second}`;
        document.getElementById('date-time').textContent = dateTimeString;
    }
    
    setInterval(updateDateTime, 1000);
    updateDateTime(); // initial call to display the time immediately
    
    setInterval(updateDateTime, 1000);
    updateDateTime(); // initial call to display the time immediately

    var ctx = document.getElementById('chartPendapatan').getContext('2d');
    var chartPendapatan = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ],
            datasets: [{
                label: 'Income',
                data: {!! json_encode(array_values($dataPendapatan)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>


@endsection
