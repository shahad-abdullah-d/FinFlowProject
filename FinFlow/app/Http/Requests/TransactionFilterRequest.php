<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'nullable',
                'in:draft,pending_review,returned,approved,rejected,completed',
            ],

            'transaction_type' => [
                'nullable',
                'in:deposit,withdrawal',
            ],

            'customer_id' => [
                'nullable',
                'integer',
                'exists:customers,id',
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'search' => [
    'nullable',
    'string',
    'max:255',
],
'sort' => [
    'nullable',
    'in:amount,-amount,created_at,-created_at',
],
        ];
    }
}