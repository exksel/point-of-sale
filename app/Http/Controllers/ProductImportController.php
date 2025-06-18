<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;

class ProductImportController extends Controller
{
    public function showImportForm()
    {
        return view('products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new ProductImport, $request->file('file'));

        return redirect()->route('products.index')->with('success', 'Products imported successfully!');
    }
}

