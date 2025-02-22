<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('add-cust-view',[CustomerController::class,'addCustView'])->name('addCustView');
    Route::post('save-cust',[CustomerController::class,'saveCust'])->name('saveCust');
    Route::get('check-mail',[CustomerController::class,'checkMail'])->name('checkMail');
    Route::get('delete-cust',[CustomerController::class,'deleteCust'])->name('deleteCust');
    Route::get('get-cust-data',[CustomerController::class,'getCustData'])->name('getCustData');
    Route::post('update-cust',[CustomerController::class,'updateCust'])->name('updateCust');

    Route::get('product-view',[ProductsController::class,'productView'])->name('productView');
    Route::post('add-product',[ProductsController::class,'addProduct'])->name('addProduct');
    Route::get('delete-product',[ProductsController::class,'deleteProduct'])->name('deleteProduct');
    Route::get('get-product',[ProductsController::class,'getProduct'])->name('getProduct');
    Route::post('update-product',[ProductsController::class,'updateProduct'])->name('updateProduct');

    Route::get('order-details',[OrderController::class,'orderDetails'])->name('orderDetails');
    Route::post('add-order',[OrderController::class,'addOrder'])->name('addOrder');
    
});

require __DIR__.'/auth.php';
