<?php
use App\Http\Controllers\TeaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FertilizerController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('teas', TeaController::class);
Route::resource('suppliers', SupplierController::class);
Route::get('/tea_stock', [SupplierController::class, 'teaStockForm'])->name('tea_stock');
Route::post('/tea_stock', [SupplierController::class, 'teaStock'])->name('tea_stock_store');
Route::get('/suppliers/{supplier}/tea-stock', [SupplierController::class, 'getTeaStock']);

Route::get('/suppliers/{id}/details', [SupplierController::class, 'showDetails']);
Route::resource('fertilizers', FertilizerController::class);
Route::get('/fertilizers_sale', [FertilizerController::class, 'fertilizerSale'])->name('fertilizers_sale');
Route::post('/fertilizers_sale/store', [FertilizerController::class, 'store'])->name('fertilizer-sale.store');



Route::resource('sales', SaleController::class);
Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');


require __DIR__.'/auth.php';
