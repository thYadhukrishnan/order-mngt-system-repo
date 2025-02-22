<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('api-login',[ApiController::class,'apiLogin'])->name('apiLogin');
Route::middleware('auth:sanctum')->group(function(){
Route::post('api-logout',[ApiController::class,'apiLogout'])->name('apiLogout');
Route::post('get-order-details',[ApiController::class,'getOrderDetails'])->name('getOrderDetails');
    
});
