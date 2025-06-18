<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select('name', 'image', 'description', 'stock', 'price')->get();
    }

    public function headings(): array
    {
        return ['name', 'image', 'description', 'stock', 'price']; // Header kolom di Excel
    }
}
