<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->status === 'approved';
    }

    public function view(User $user, Transaction $transaction): bool
{
    return $user->role === 'admin'
        || $user->role === 'manager'
        || $transaction->created_by === $user->id;
}

    public function create(User $user): bool
    {
        return $user->status === 'approved'
            && in_array($user->role, ['employee', 'manager', 'admin']);
    }

    public function approve(User $user, Transaction $transaction): bool
{
    return in_array($user->role, ['manager', 'admin'])
        && $transaction->status === 'pending_review'
        && $transaction->created_by !== $user->id;
}
    public function reject(User $user, Transaction $transaction): bool
    {
        return in_array($user->role, ['manager', 'admin'])
            && $transaction->status === 'pending_review'
            && $transaction->created_by !== $user->id;
    }
}