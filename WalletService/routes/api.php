<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTransactionController;

Route::post('/wallets', [WalletController::class, 'store']);
Route::get('/wallets/{customerId}', [WalletController::class, 'show']);

Route::post('/wallets/deposit', [WalletTransactionController::class, 'deposit']);
Route::post('/wallets/withdraw', [WalletTransactionController::class, 'withdraw']);