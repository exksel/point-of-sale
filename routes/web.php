<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
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

Route::get('/', [PageController::class, 'home'])->name('landing.home');
Route::get('/menu', [ProductController::class, 'menu'])->name('landing.menu');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/menu', [ProductController::class, 'menu'])->name('menu');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::resource('products', ProductController::class);

// Route::get('/transactions/cashier', [TransactionController::class, 'cashier'])->name('transactions.cashier');
// Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
// Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
// Route::get('/transaction/{transaction_code}', [TransactionController::class, 'show'])->name('transaction.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/transactions/cashier', [TransactionController::class, 'cashier'])->name('transactions.cashier');
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transaction/{transaction_code}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::get('/transactions/export-excel', function () {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



