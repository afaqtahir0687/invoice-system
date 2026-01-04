<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('quotes', QuoteController::class);
    Route::get('quotes/{quote}/convert', [QuoteController::class, 'convertToInvoice'])->name('quotes.convert');
    Route::get('quotes/{quote}/pdf', [QuoteController::class, 'downloadPdf'])->name('quotes.pdf');
    
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::post('invoices/{invoice}/payments', [PaymentController::class, 'store'])->name('payments.store');
    
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
