<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([

            'total_customers' => Customer::count(),

            'total_transactions' => Transaction::count(),

            'pending_transactions' =>
                Transaction::where('status', 'pending_review')->count(),

            'approved_transactions' =>
                Transaction::where('status', 'approved')->count(),

            'rejected_transactions' =>
                Transaction::where('status', 'rejected')->count(),

            'total_deposit' =>
                Transaction::where('transaction_type', 'deposit')
                    ->where('status', 'approved')
                    ->sum('amount'),

            'total_withdrawal' =>
                Transaction::where('transaction_type', 'withdrawal')
                    ->where('status', 'approved')
                    ->sum('amount'),

        ]);
    }
}