<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExpensesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $expenses;
    protected $totalExpense;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();
    }

    public function collection()
    {
        $this->expenses = Expense::whereBetween('expense_date', [$this->startDate, $this->endDate])->get();

        $this->totalExpense = $this->expenses->sum('expense_total');

        return $this->expenses;
    }

    public function headings(): array
    {
        return [
            'Expense ID',
            'Expense Name',
            'Quantity',
            'Note',
            'Total (Rp)',
            'Date & Time',
        ];
    }

    public function map($expense): array
    {
        return [
            $expense->expense_id,
            $expense->expense_name,
            $expense->quantity,
            $expense->note ?? '-',
            'Rp ' . number_format($expense->expense_total, 0, ',', '.'),
            Carbon::parse($expense->expense_date)->format('d-m-Y H:i'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $rowCount = count($this->expenses) + 2; // +1 header, +1 offset
                $sheet->setCellValue('D' . $rowCount, 'Total Expense:');
                $sheet->setCellValue('E' . $rowCount, 'Rp ' . number_format($this->totalExpense, 0, ',', '.'));

                // Bold the total row
                $sheet->getStyle("D{$rowCount}:E{$rowCount}")->getFont()->setBold(true);

                // Highlight rows with same date
                $dateGroups = [];

                foreach ($this->expenses as $index => $expense) {
                    $date = Carbon::parse($expense->expense_date)->format('Y-m-d');
                    $excelRow = $index + 2;

                    $dateGroups[$date][] = $excelRow;
                }

                $colors = ['FFFFCC', 'CCE5FF', 'D5F5E3', 'FADBD8', 'E8DAEF'];

                $colorIndex = 0;
                foreach ($dateGroups as $rows) {
                    $fillColor = $colors[$colorIndex % count($colors)];
                    foreach ($rows as $row) {
                        $sheet->getStyle("A{$row}:F{$row}")->getFill()->setFillType(Fill::FILL_SOLID)
                              ->getStartColor()->setARGB($fillColor);
                    }
                    $colorIndex++;
                }
            },
        ];
    }
}
