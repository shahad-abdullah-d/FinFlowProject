<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\WalletOperationRequest;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletTransactionController extends Controller
{
   public function deposit(WalletOperationRequest $request)
{
    $data = $request->validated();

    $wallet = Wallet::where('customer_id', $data['customer_id'])
        ->firstOrFail();

    $balanceBefore = $wallet->balance;
    $balanceAfter = $balanceBefore + $data['amount'];

    $wallet->update([
        'balance' => $balanceAfter,
    ]);

    $transaction = WalletTransaction::create([
        'wallet_id' => $wallet->id,
        'type' => 'deposit',
        'amount' => $data['amount'],
        'balance_before' => $balanceBefore,
        'balance_after' => $balanceAfter,
        'reference' => $data['reference'] ?? null,
    ]);

    return response()->json([
        'message' => 'Deposit completed successfully',
        'wallet' => $wallet,
        'transaction' => $transaction,
    ], 200);
}

public function withdraw(WalletOperationRequest $request)
{
    $data = $request->validated();

    $wallet = Wallet::where('customer_id', $data['customer_id'])
        ->firstOrFail();

    $balanceBefore = $wallet->balance;

    if ($balanceBefore < $data['amount']) {
        return response()->json([
            'message' => 'Insufficient balance',
        ], 422);
    }

    $balanceAfter = $balanceBefore - $data['amount'];

    $wallet->update([
        'balance' => $balanceAfter,
    ]);

    $transaction = WalletTransaction::create([
        'wallet_id' => $wallet->id,
        'type' => 'withdraw',
        'amount' => $data['amount'],
        'balance_before' => $balanceBefore,
        'balance_after' => $balanceAfter,
        'reference' => $data['reference'] ?? null,
    ]);

    return response()->json([
        'message' => 'Withdrawal completed successfully',
        'wallet' => $wallet,
        'transaction' => $transaction,
    ], 200);
}

}
