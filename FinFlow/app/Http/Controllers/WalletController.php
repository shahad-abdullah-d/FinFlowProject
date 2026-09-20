<?php

namespace App\Http\Controllers;

use App\Services\WalletServiceClient;

class WalletController extends Controller
{
    public function show(
        int $customerId,
        WalletServiceClient $walletService
    ) {
        return response()->json(
            $walletService->getWallet($customerId)
        );
    }
}