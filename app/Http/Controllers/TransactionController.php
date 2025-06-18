<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Mail\TransactionReceipt;



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
            $nextTransactionNumber = $latestTransaction ? intval(substr($latestTransaction->transaction_code, 3)) + 1 : 1;
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

            // Ambil email dari request
            $email = $request->input('email');

            // Simpan data transaksi
            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'cashier_name' => Auth::user()->full_name,
                'email' => $email,
                'total' => $total,
                'paid' => $request->paid,
                'change' => $request->paid - $total,
                'payment_type' => $request->payment_type,
            ]);

            // Simpan detail transaksi dan kurangi stok produk
            foreach ($products as $productId => $details) {
                if ($details['quantity'] > 0) {
                    $product = Product::find($productId);

                    // Cek apakah stok mencukupi
                    if ($product->stock < $details['quantity']) {
                        DB::rollback(); // Batalkan transaksi
                        return back()->with('error', 'Stok tidak mencukupi untuk produk: ' . $product->name);
                    }

                    // Simpan detail transaksi
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $details['quantity'],
                        'subtotal' => $product->price * $details['quantity'],
                    ]);

                    // Kurangi stok produk
                    $product->stock -= $details['quantity'];
                    $product->save();
                }
            }

            DB::commit(); // Simpan semua perubahan ke database

            // **Panggil method sendReceipt setelah transaksi sukses**
            if (!empty($transaction->email)) {
                $this->sendReceipt($transaction);
            }

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

    public function showExportForm()
    {
        return view('transactions.export');
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $filename = 'transactions_' . 
            \Carbon\Carbon::parse($startDate)->format('d-M-Y') . 
            '_to_' . 
            \Carbon\Carbon::parse($endDate)->format('d-M-Y') . 
            '.xlsx';

        return Excel::download(new TransactionsExport($startDate, $endDate), $filename);
    }

    // Mengirim email otomatis
    public function sendReceipt($transaction)
    {
        Mail::to($transaction->email)->send(new TransactionReceipt($transaction));
    }

}

