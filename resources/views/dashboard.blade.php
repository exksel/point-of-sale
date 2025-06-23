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

    #topProductsList {
    list-style: none;
    padding: 0;
    margin-top: 15px;
    font-size: 14px;
    }

    #topProductsList li {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .legend-color {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
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
    

    <!-- TOP SECTION: Summary Cards + Pie Chart -->
    <div class="row g-3 d-flex align-items-stretch">
        <!-- Summary Cards -->
        <div class="col-md-9">
            <div class="row g-3 h-100">
                @foreach ([
                    ['icon' => 'bi-box', 'title' => 'Products', 'value' => $jumlahProduk, 'subtitle' => 'Total'],
                    ['icon' => 'bi-cart-check', 'title' => 'Transaction Records', 'value' => $jumlahTransaksi, 'subtitle' => 'Total'],
                    ['icon' => 'bi bi-bag-dash', 'title' => 'Expense Records', 'value' => $jumlahRecordExpense, 'subtitle' => 'Total'],
                    ['icon' => 'bi-coin', 'title' => 'Income', 'value' => 'Rp ' . number_format($totalPemasukanPerHari, 0, ',', '.'), 'subtitle' => 'Today'],
                    ['icon' => 'bi-cart-dash', 'title' => 'Expense', 'value' => 'Rp ' . number_format($totalPengeluaranPerHari, 0, ',', '.'), 'subtitle' => 'Today'],
                    ['icon' => 'bi bi-cash-coin', 'title' => 'Profit', 'value' => 'Rp ' . number_format($totalProfitPerHari, 0, ',', '.'), 'subtitle' => 'Today'],
                ] as $item)
                    <div class="col-md-4">
                        <div class="card card-custom p-3 h-100">
                            <div class="card-body">
                                <i class="bi {{ $item['icon'] }} card-icon"></i>
                                <h5 class="card-title">{{ $item['title'] }}</h5>
                                <strong>{{ $item['value'] }}</strong>
                                <p class="text-muted mt-2">{{ $item['subtitle'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-md-3">
            <div class="card shadow p-3 h-100 d-flex flex-column justify-content-between" style="height: 100%;">
                <h5 class="text-primary text-center mb-2">Top 5 Best Selling Product</h5>
                <canvas id="chartProduk" style="max-height: 200px;"></canvas>
                <ul id="topProductsList" class="list-unstyled small mt-3 text-center"></ul>
            </div>
        </div>
    </div>

    <!-- Monthly Charts -->
    <div class="mt-4">
        <!-- Monthly Income -->
        <div class="card shadow p-4 mb-4">
            <h5 class="text-primary text-center mb-3">Monthly Income</h5>
            <canvas id="chartPendapatan" style="height: 350px; max-height: 350px;"></canvas>
        </div>

        <!-- Monthly Expense -->
        <div class="card shadow p-4 mb-4">
            <h5 class="text-danger text-center mb-3">Monthly Expense</h5>
            <canvas id="chartPengeluaran" style="height: 350px; max-height: 350px;"></canvas>
        </div>

        <!-- Monthly Profit -->
        <div class="card shadow p-4">
            <h5 class="text-success text-center mb-3">Monthly Profit</h5>
            <canvas id="chartProfit" style="height: 350px; max-height: 350px;"></canvas>
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

    // Pie Chart Top 5 Best Selling Product
    var produkSeringDibeli = @json($produkSeringDibeli);
    var labels = produkSeringDibeli.map(item => item.product ? item.product.name : 'Unknown');
    var data = produkSeringDibeli.map(item => item.total_qty);

    var ctx = document.getElementById("chartProduk").getContext("2d");
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#9C27B0'],
                hoverOffset: 5
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false // Ini menyembunyikan legenda bawaan
                }
            }
        }
    });


    // Tampilkan daftar Top 5 Products di bawah Pie Chart
    var productColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#9C27B0'];
    var totalQtyBulanIni = produkSeringDibeli.reduce((sum, item) => sum + item.total_qty, 0);
    var productList = document.getElementById("topProductsList");

    produkSeringDibeli.forEach((item, index) => {
        var productName = item.product ? item.product.name : 'Unknown';
        var percentage = ((item.total_qty / totalQtyBulanIni) * 100).toFixed(2);
        var li = document.createElement("li");

        li.innerHTML = `
            <span class="legend-color" style="background-color:${productColors[index]}"></span>
            <span>${productName}</span>
            <span class="ms-auto">${item.total_qty} pcs</span>
        `;
        productList.appendChild(li);
    });

    // Chart Monthly Income
    var dataPendapatan = @json(array_values($dataPendapatan));
    var ctxBar = document.getElementById("chartPendapatan").getContext("2d");
    new Chart(ctxBar, {
        type: "bar",
        data: {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            datasets: [{
                label: "Income",
                data: dataPendapatan,
                backgroundColor: "rgba(54, 162, 235, 0.5)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart Pengeluaran Setiap Bulan
    var dataPengeluaran = @json(array_values($dataPengeluaran));
    var ctxBarExpense = document.getElementById("chartPengeluaran").getContext("2d");
    new Chart(ctxBarExpense, {
        type: "bar",
        data: {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            datasets: [{
                label: "Expense",
                data: dataPengeluaran,
                backgroundColor: "rgba(255, 99, 132, 0.5)",   // Merah lembut
                borderColor: "rgba(255, 99, 132, 1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart Monthly Profit
    var dataProfit = @json(array_values($dataProfit));
    var ctxProfit = document.getElementById("chartProfit").getContext("2d");
    new Chart(ctxProfit, {
        type: "bar",
        data: {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            datasets: [{
                label: "Profit",
                data: dataProfit,
                backgroundColor: "rgba(40, 167, 69, 0.5)",
                borderColor: "rgba(40, 167, 69, 1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>


@endsection
