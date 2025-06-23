<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Exports\ProductExport;
use App\Exports\TransactionsExport;
use App\Exports\ExpensesExport;
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
Route::get('/aboutus', [PageController::class, 'aboutus'])->name('landing.aboutus');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/menu', [ProductController::class, 'menu'])->name('menu');
Route::get('/aboutus', [PageController::class, 'aboutus'])->name('aboutus');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);


// Route::get('/register', function () {
//     return view('auth.register'); 
// })->name('register');

// Route::post('/register', [AuthController::class, 'register']);


Route::get('/products/import', [ProductImportController::class, 'showImportForm'])->name('products.import');
    Route::post('/products/import', [ProductImportController::class, 'import'])->name('products.import.store');
    Route::get('/products/export', function () {
        return Excel::download(new ProductExport, 'products.xlsx');
    })->name('products.export')->middleware('auth');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    
    Route::get('/transactions/cashier', [TransactionController::class, 'cashier'])->name('transactions.cashier');
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transaction/{transaction_code}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::get('/transactions/export', [TransactionController::class, 'showExportForm'])->name('transactions.export.form');
    Route::post('/transactions/export/preview', [TransactionController::class, 'preview'])->name('transactions.export.preview');
    Route::post('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('outcomes.list');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('outcomes.addexpense');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/export', [ExpenseController::class, 'showExportForm'])->name('outcomes.export2.form');
    Route::post('/expenses/preview', [ExpenseController::class, 'preview'])->name('outcomes.preview2');
    Route::post('/expenses/export', [ExpenseController::class, 'export'])->name('outcomes.export2');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



