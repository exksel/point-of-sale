<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total produk
        $jumlahProduk = Product::count();

        // Jumlah transaksi bulan ini
        $jumlahTransaksi = Transaction::whereMonth('transaction_date', Carbon::now()->month)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->count();

        // Total pemasukan bulan ini
        $totalPemasukanPerBulan = Transaction::whereMonth('transaction_date', Carbon::now()->month)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->sum('total');

        // Pendapatan per hari
        $totalPemasukanPerHari = Transaction::whereDate('transaction_date', Carbon::today())
        ->sum('total');

        // Produk yang sering dibeli (Top 5)
        $produkSeringDibeli = TransactionDetail::selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        // Ambil pendapatan per bulan
        $pendapatanPerBulan = Transaction::selectRaw('MONTH(transaction_date) as bulan, SUM(total) as total_pendapatan')
            ->whereYear('transaction_date', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Inisialisasi semua bulan (1-12) dengan nilai 0
        $dataPendapatan = array_fill(1, 12, 0);

        // Masukkan pendapatan yang tersedia ke dalam array
        foreach ($pendapatanPerBulan as $data) {
            $dataPendapatan[$data->bulan] = $data->total_pendapatan;
        }

        return view('dashboard', compact(
            'jumlahProduk', 'jumlahTransaksi', 'totalPemasukanPerHari',
            'totalPemasukanPerBulan', 'produkSeringDibeli', 'dataPendapatan'
        ));
    }
}
