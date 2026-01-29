<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HarakaPayService
{
    private string $baseUrl = 'https://harakapay.net';
    private ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = Setting::get('harakapay_api_key');
    }

    /**
     * Check if payment is enabled
     */
    public function isEnabled(): bool
    {
        return (bool) Setting::get('payment_enabled', true);
    }

    /**
     * Collect payment from user
     */
    public function collectPayment(string $phone, float $amount, string $description = ''): array
    {
        if (!$this->apiKey) {
            return [
                'success' => false,
                'error' => 'API key not configured'
            ];
        }

        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'error' => 'Payments are currently disabled'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-API-Key' => $this->apiKey,
            ])->post($this->baseUrl . '/api/v1/collect', [
                        'phone' => $phone,
                        'amount' => $amount,
                        'description' => $description,
                    ]);

            $data = $response->json();

            Log::info('HarakaPay collect response', [
                'phone' => $phone,
                'amount' => $amount,
                'response' => $data,
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('HarakaPay collect error', [
                'phone' => $phone,
                'amount' => $amount,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Payment service unavailable: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check payment status
     */
    public function checkStatus(string $orderId): array
    {
        if (!$this->apiKey) {
            return [
                'success' => false,
                'error' => 'API key not configured'
            ];
        }

        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
            ])->get($this->baseUrl . '/api/v1/status/' . $orderId);

            $data = $response->json();

            Log::info('HarakaPay status check', [
                'order_id' => $orderId,
                'response' => $data,
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('HarakaPay status error', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Unable to check payment status'
            ];
        }
    }

    /**
     * Get wallet balance
     */
    public function getBalance(): array
    {
        if (!$this->apiKey) {
            return [
                'success' => false,
                'error' => 'API key not configured'
            ];
        }

        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
            ])->get($this->baseUrl . '/api/v1/balance');

            return $response->json();
        } catch (\Exception $e) {
            Log::error('HarakaPay balance error', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'error' => 'Unable to get balance'
            ];
        }
    }
}
