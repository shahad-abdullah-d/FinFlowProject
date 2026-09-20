<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'reviewed_by',
        'status',
        'comment',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}