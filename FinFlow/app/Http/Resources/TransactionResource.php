<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_type' => $this->transaction_type,
            'amount' => $this->amount,
            'status' => $this->status,
            'notes' => $this->notes,

            'customer' => [
                'id' => $this->customer?->id,
                'name' => $this->customer?->name,
                'email' => $this->customer?->email,
            ],

            'creator' => [
                'id' => $this->creator?->id,
                'name' => $this->creator?->name,
                'role' => $this->creator?->role,
            ],

            'approver' => $this->approver ? [
                'id' => $this->approver->id,
                'name' => $this->approver->name,
            ] : null,

            'reviews' => $this->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'status' => $review->status,
                    'comment' => $review->comment,
                    'reviewer' => [
                        'id' => $review->reviewer?->id,
                        'name' => $review->reviewer?->name,
                    ],
                ];
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}