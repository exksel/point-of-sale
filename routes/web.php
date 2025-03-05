<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);

Route::get('/transactions/cashier', [TransactionController::class, 'cashier'])->name('transactions.cashier');
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
Route::get('/transaction/{transaction_code}', [TransactionController::class, 'show'])->name('transaction.show');



