<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->get(); // Mengambil semua produk tanpa pagination
        return view('products.index', compact('products'))->with('i', 0);
    }

    // menampilkan menu di landing
    public function menu()
    {
        $products = Product::orderBy('id', 'asc')->get(); // Ambil produk
        return view('landing.menu', compact('products')); // Tampilkan di menu.blade.php
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'stock' => 'required|integer|min:0',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $data = $request->all();

        // Jika ada file gambar yang diupload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $data['image'] = 'uploads/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product berhasil dibuat!.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'stock' => 'required|integer|min:0',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $data = $request->all();

        // Jika ada file gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $data['image'] = 'uploads/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product berhasil diupdate!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
  
        return redirect()->route('products.index')->with('success','Product berhasil dihapus!');
    }
}
