<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;

use App\Http\Controllers\WalletController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
    return response()->json($request->user());
});


    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);

    Route::patch('/customers/{id}/status', [CustomerController::class, 'updateStatus']);
    
     Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::get('/wallets/{customerId}', [
    WalletController::class,'show',]);
    Route::patch('/transactions/{transaction}/approve', [
    TransactionController::class,
    'approve'
]);
Route::patch('/transactions/{id}/reject', [TransactionController::class, 'reject']);
});