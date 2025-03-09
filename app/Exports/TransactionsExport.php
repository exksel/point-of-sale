<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Transaction::with('details.product')->get(); // Mengambil transaksi beserta detail produknya
    }

    public function headings(): array
    {
        return [
            'Transaction Code',
            'Product Name',
            'Total Price',
            'Paid',
            'Change',
            'Date & Time',
            'Quantity',
            'Subtotal'
        ];
    }

    public function map($transaction): array
    {
        $rows = [];

        foreach ($transaction->details as $detail) {
            $rows[] = [
                $transaction->transaction_code,
                $detail->product->name ?? 'Unknown Product',
                'Rp ' . number_format($transaction->total, 0, ',', '.'),
                'Rp ' . number_format($transaction->paid, 0, ',', '.'),
                'Rp ' . number_format($transaction->change, 0, ',', '.'),
                Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i'),
                $detail->quantity,
                'Rp ' . number_format($detail->subtotal, 0, ',', '.')
            ];
        }

        return $rows;
    }
}
