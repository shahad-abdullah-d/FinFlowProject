<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\RejectTransactionRequest;
use App\Models\TransactionReview;

use App\Http\Resources\TransactionResource;
use App\Http\Requests\TransactionFilterRequest;
use App\Services\WalletServiceClient;

class TransactionController extends Controller
{

public function index(TransactionFilterRequest $request)
{
    Gate::authorize('viewAny', Transaction::class);

    $filters = $request->validated();
    $user = $request->user();

    $query = Transaction::with([
        'customer',
        'creator',
        'approver',
    ]);

    // Role Filtering
    if ($user->role === 'employee') {
        $query->where('created_by', $user->id);

    } elseif ($user->role === 'manager') {
        // يشوف كل العمليات

    } elseif ($user->role === 'admin') {
        // يشوف كل العمليات

    } else {
        return response()->json([
            'message' => 'Unauthorized',
        ], 403);
    }

    // Status Filter
    if (isset($filters['status'])) {
        $query->where('status', $filters['status']);
    }

    // Transaction Type Filter
    if (isset($filters['transaction_type'])) {
        $query->where('transaction_type', $filters['transaction_type']);
    }

    // Customer Filter
    if (isset($filters['customer_id'])) {
        $query->where('customer_id', $filters['customer_id']);
    }

    // Search
    if (isset($filters['search'])) {

        $query->where(function ($q) use ($filters) {

            $q->where('transaction_type', 'like', "%{$filters['search']}%")
              ->orWhere('notes', 'like', "%{$filters['search']}%")
              ->orWhereHas('customer', function ($customer) use ($filters) {

                    $customer->where('name', 'like', "%{$filters['search']}%")
                             ->orWhere('email', 'like', "%{$filters['search']}%");

              });

        });
    }

    // Sorting
    if (isset($filters['sort'])) {

        switch ($filters['sort']) {

            case 'amount':
                $query->orderBy('amount');
                break;

            case '-amount':
                $query->orderByDesc('amount');
                break;

            case 'created_at':
                $query->orderBy('created_at');
                break;

            case '-created_at':
                $query->orderByDesc('created_at');
                break;

            default:
                $query->latest();
        }

    } else {
        $query->latest();
    }

    $transactions = $query->paginate(10);

    return TransactionResource::collection($transactions);
}


public function show(string $id)
{
    $transaction = Transaction::with([
        'customer',
        'creator',
        'approver',
        'reviews.reviewer',
    ])->findOrFail($id);

    Gate::authorize('view', $transaction);

    return new TransactionResource($transaction);
}

public function store(StoreTransactionRequest $request)
{
    $data = $request->validated();

    Gate::authorize('create', Transaction::class);

    $data['created_by'] = $request->user()->id;
    $data['status'] = 'pending_review';

    $transaction = Transaction::create($data);

    $transaction->load('customer');

    return response()->json($transaction, 201);
}


public function approve(
    Request $request,
    Transaction $transaction,
    WalletServiceClient $walletService
) {
    Gate::authorize('approve', $transaction);

    if ($transaction->status !== 'pending_review') {
    return response()->json([
        'message' => 'Transaction has already been reviewed',
    ], 422);
}

    if ($transaction->transaction_type === 'deposit') {
        $walletService->deposit(
            $transaction->customer_id,
            $transaction->amount,
            (string) $transaction->id
        );
    }

    if ($transaction->transaction_type === 'withdraw') {
        $walletService->withdraw(
            $transaction->customer_id,
            $transaction->amount,
            (string) $transaction->id
        );
    }

    $transaction->update([
        'status' => 'approved',
        'approved_by' => $request->user()->id,
    ]);

    return new TransactionResource(
        $transaction->fresh()->load('customer')
    );
}


public function reject(
    RejectTransactionRequest $request,
    string $id
) {
    $transaction = Transaction::findOrFail($id);

    Gate::authorize('reject', $transaction);

    $transaction->update([
        'status' => 'rejected',
        'approved_by' => null,
    ]);

    $review = TransactionReview::create([
        'transaction_id' => $transaction->id,
        'reviewed_by' => $request->user()->id,
        'status' => 'rejected',
        'comment' => $request->validated()['comment'],
    ]);

    $transaction->load('customer');

    return response()->json([
        'message' => 'Transaction rejected successfully.',
        'transaction' => $transaction,
        'review' => $review,
    ]);
}




}
