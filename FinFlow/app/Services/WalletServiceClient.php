<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WalletServiceClient
{
    private string $baseUrl = 'http://127.0.0.1:8001/api';

    public function createWallet(int $customerId): array
    {
        $response = Http::post($this->baseUrl . '/wallets', [
            'customer_id' => $customerId,
            'balance' => 0,
        ]);

        $response->throw();

        return $response->json();
    }

    public function getWallet(int $customerId): array
{
    $response = Http::get(
        $this->baseUrl . '/wallets/' . $customerId
    );

    $response->throw();

    return $response->json();
}

    public function deposit(
        int $customerId,
        float $amount,
        string $reference
    ): array {
        $response = Http::post($this->baseUrl . '/wallets/deposit', [
            'customer_id' => $customerId,
            'amount' => $amount,
            'reference' => $reference,
        ]);

        $response->throw();

        return $response->json();
    }

    public function withdraw(
        int $customerId,
        float $amount,
        string $reference
    ): array {
        $response = Http::post($this->baseUrl . '/wallets/withdraw', [
            'customer_id' => $customerId,
            'amount' => $amount,
            'reference' => $reference,
        ]);

        $response->throw();

        return $response->json();
    }
}