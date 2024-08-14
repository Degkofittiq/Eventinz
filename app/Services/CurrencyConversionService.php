<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class CurrencyConversionService
{

    public function convert($amount, $fromCurrency, $toCurrency)
    {
        try {        
            $apiKey = config('services.exchange_rate_api.key');
            $baseUrl = "https://v6.exchangerate-api.com/v6/{$apiKey}/pair/{$fromCurrency}/{$toCurrency}/{$amount}";
            $response = Http::get($baseUrl);
            
            if ($response->successful()) {
                return $response->json()['conversion_result'];
            }
        } catch (\Exception $e) {
            // Log l'exception ou afficher un message d'erreur personnalisé
            // \Log::error('Failed to fetch exchange rates: ' . $e->getMessage());
            throw new Exception('Failed to fetch exchange rates');
        }

    }
}