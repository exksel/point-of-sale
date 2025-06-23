<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Expense;
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
        
        // Menghitung expense record
        $jumlahRecordExpense = Expense::count();

        // Total pengeluaran hari ini
        $totalPengeluaranPerHari = Expense::whereDate('created_at', Carbon::today())
            ->sum('expense_total');

        // Pengeluaran per bulan
        $totalPengeluaranPerBulan = Expense::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('expense_total');

        // Profit hari ini
        $totalProfitPerHari = $totalPemasukanPerHari - $totalPengeluaranPerHari;
            
        // Chart Pengeluaran Per Bulan
        $pengeluaranPerBulan = Expense::selectRaw('MONTH(created_at) as bulan, SUM(expense_total) as total_pengeluaran')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $dataPengeluaran = array_fill(1, 12, 0);
        foreach ($pengeluaranPerBulan as $data) {
            $dataPengeluaran[$data->bulan] = $data->total_pengeluaran;
        }

        // Chart profit per bulan
        $dataProfit = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataProfit[$i] = $dataPendapatan[$i] - $dataPengeluaran[$i];
        }


        return view('dashboard', compact(
            'jumlahProduk', 'jumlahTransaksi', 'totalPemasukanPerHari',
            'produkSeringDibeli', 'dataPendapatan', 'totalPengeluaranPerBulan', 
            'dataPengeluaran', 'dataProfit', 'totalPengeluaranPerHari', 'totalProfitPerHari', 'jumlahRecordExpense'

        ));
    }
}
