<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class TransactionsExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $rows = [];
    protected $rowHighlightMap = [];

    public function __construct($startDate, $endDate)
    {
        $start = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $transactions = Transaction::with('details.product')
            ->whereBetween('transaction_date', [$start, $end])
            ->get();

        $rowIndex = 2;

        foreach ($transactions as $transaction) {
            $firstRow = true;
            $startRow = $rowIndex;

            foreach ($transaction->details as $detail) {
                $this->rows[] = [
                    $transaction->transaction_code,
                    $firstRow ? $transaction->email : null,
                    $detail->product->name ?? 'Unknown Product',
                    $detail->quantity,
                    $detail->subtotal,
                    $firstRow ? $transaction->total : null,
                    $firstRow ? $transaction->paid : null,
                    $firstRow ? $transaction->change : null,
                    $transaction->payment_type,
                    Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i'),
                ];
                $rowIndex++;
                $firstRow = false;
            }

            $endRow = $rowIndex - 1;
            $this->rowHighlightMap[] = [$startRow, $endRow];
        }

        $totalIncome = $transactions->sum('total');
        $this->rows[] = ['', '', '', '', 'Total Income:', $totalIncome];
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Transaction Code',
            'Cust Email',
            'Product Name',
            'Quantity',
            'Subtotal',
            'Total Price',
            'Paid',
            'Change',
            'Payment Type',
            'Date & Time',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $colors = ['#f0f9ff', '#fef3c7', '#f0fdf4', '#f3e8ff', '#ffe4e6'];
                $colorIndex = 0;

                foreach ($this->rowHighlightMap as [$start, $end]) {
                    $fillColor = $colors[$colorIndex % count($colors)];
                    $event->sheet->getStyle("A{$start}:J{$end}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => ltrim($fillColor, '#')],
                        ],
                    ]);
                    $colorIndex++;
                }

                $lastRow = count($this->rows) + 1;
                $event->sheet->getStyle("E{$lastRow}:F{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'd1fae5'],
                    ],
                ]);
            },
        ];
    }
}
