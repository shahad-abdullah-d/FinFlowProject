<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
     use HasFactory;
   protected $fillable = [
    'customer_id',
    'created_by',
    'approved_by',
    'transaction_type',
    'amount',
    'status',
    'notes',
];

public function customer()
{
    return $this->belongsTo(Customer::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}

public function reviews()
{
    return $this->hasMany(TransactionReview::class);
}
}
