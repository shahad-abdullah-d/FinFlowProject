<?php

namespace App\Http\Controllers;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWalletRequest;

class WalletController extends Controller
{
   public function show($customerId)
{
    $wallet = Wallet::where('customer_id', $customerId)
        ->with('transactions')
        ->firstOrFail();

    return response()->json([
        'wallet' => $wallet,
    ]);
}

public function store(StoreWalletRequest $request)
{
    $data = $request->validated();

    $wallet = Wallet::create([
        'customer_id' => $data['customer_id'],
        'balance' => $data['balance'] ?? 0,
    ]);

    return response()->json([
        'message' => 'Wallet created successfully',
        'wallet' => $wallet,
    ], 201);
}
}
