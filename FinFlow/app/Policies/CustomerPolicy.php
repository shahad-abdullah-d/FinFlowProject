<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->status === 'approved';
    }

    public function view(User $user, Customer $customer): bool
    {
        return $user->status === 'approved';
    }

    public function create(User $user): bool
    {
        return $user->status === 'approved';
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->status === 'approved';
    }

    public function updateStatus(User $user, Customer $customer): bool
    {
        return $user->status === 'approved'
            && in_array($user->role, ['manager', 'admin']);
    }
}