<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Exports\ExpensesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'asc')->get();
        return view('outcomes.list', compact('expenses'));
    }

    public function create()
    {
        return view('outcomes.addexpense');
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Ambil angka terakhir dari expense_id (EXP1, EXP2, dst)
            $lastNumber = Expense::selectRaw("MAX(CAST(SUBSTRING(expense_id, 4) AS UNSIGNED)) as last_number")
                ->value('last_number');

            $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

            $newExpenseID = 'EXP' . $nextNumber;


            // Simpan data expense
            Expense::create([
                'expense_id' => $newExpenseID,
                'expense_name' => $request->expense_name,
                'quantity' => $request->quantity,
                'expense_total' => $request->expense_total,
                'note' => $request->note,
                'expense_date' => now(),
            ]);

            DB::commit(); // Simpan perubahan ke database

            return redirect()->route('outcomes.list')->with('success', 'Expense added successfully!');
        } catch (\Exception $e) {
            DB::rollback(); // Batalkan semua perubahan jika terjadi error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showExportForm()
    {
        return view('outcomes.export2');
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end = $request->end_date;

        $filename = 'expenses_' . date('d-m-Y', strtotime($start)) . '_to_' . date('d-m-Y', strtotime($end)) . '.xlsx';

        return Excel::download(new ExpensesExport($start, $end), $filename);
    }


}
