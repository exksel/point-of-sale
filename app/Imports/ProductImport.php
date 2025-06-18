<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan semua kunci ada untuk menghindari "Undefined array key"
        if (!isset($row['name'], $row['description'], $row['stock'], $row['price'])) {
            return null; // Abaikan jika format tidak sesuai
        }

        // Cek apakah produk sudah ada berdasarkan nama, deskripsi, dan harga
        $exists = Product::where('name', $row['name'])
            ->where('description', $row['description'])
            ->where('price', $row['price'])
            ->exists(); // Menggunakan `exists()` agar lebih efisien

        // Jika produk sudah ada, lewati tanpa menghentikan import
        if ($exists) {
            return null;
        }

        // Jika produk belum ada, tambahkan
        return new Product([
            'name'        => $row['name'],
            'description' => $row['description'],
            'stock'       => $row['stock'],
            'price'       => $row['price'],
        ]);
    }
}
