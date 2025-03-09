<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function cashier()
    {
        $products = Product::all(); // Ambil semua produk dari database
        return view('transactions.cashier', compact('products'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Ambil transaksi terbaru
            $latestTransaction = Transaction::latest()->first();

            // Ambil angka dari kode terakhir, jika ada
            $nextTransactionNumber = $latestTransaction ? intval(substr($latestTransaction->transaction_code, 3)) + 1 : 1;

            // Format kode transaksi baru (TRX1, TRX2, TRX3, ...)
            $transactionCode = 'TRX' . $nextTransactionNumber;

            // Hitung total harga dari produk yang dipilih
            $total = 0;
            $products = $request->input('products', []);

            foreach ($products as $productId => $details) {
                $product = Product::find($productId);
                if ($product && isset($details['quantity']) && $details['quantity'] > 0) {
                    $subtotal = $product->price * $details['quantity'];
                    $total += $subtotal;
                }
            }

            // Simpan data transaksi
            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'total' => $total,
                'paid' => $request->paid,
                'change' => $request->paid - $total,
            ]);

            // Simpan detail transaksi
            foreach ($request->products as $productId => $details) {
                if ($details['quantity'] > 0) {
                    $product = Product::find($productId); // Ambil produk
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name, // Simpan nama produk
                        'quantity' => $details['quantity'],
                        'subtotal' => $product->price * $details['quantity'],
                    ]);
                }
            }

            DB::commit(); // Simpan semua perubahan ke database

            return redirect()->route('transactions.history')->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollback(); // Batalkan semua perubahan jika terjadi error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function history()
    {
        $transactions = Transaction::orderBy('transaction_date', 'asc')->get();
        return view('transactions.history', compact('transactions'));
    }

        public function show($transaction_code)
    {
        $transaction = Transaction::where('transaction_code', $transaction_code)->with('details')->firstOrFail();

        return view('transactions.show', compact('transaction'));
    }

}

