<?php

namespace App\Services;

use Throwable;
use App\Models\Paymenthistory;
use App\Services\PayPalService;
use App\Services\MTNMomoService;
use App\Services\CurrencyConversionService;

class PaymentService
{
    private $paypalService;
    private $mtnMomoService;
    private $currencyConversionService;

    public function __construct(PayPalService $paypalService, MTNMomoService $mtnMomoService, CurrencyConversionService $currencyConversionService)
    {
        $this->paypalService = $paypalService;
        $this->mtnMomoService = $mtnMomoService;
        $this->currencyConversionService = $currencyConversionService;
    }

    public function initiate(string $method, Paymenthistory $payment)
    {
        switch ($method) {
            case 'paypal':
                try {
                    $paypalAmount = round($this->currencyConversionService->convert($payment->amount, $payment->currency, 'USD'), 2);
                    $payment->update(['amount' => $paypalAmount, 'currency' => 'USD']);
                    return $this->paypalService->initiate($payment);
                } catch (\Throwable $th) {
                    $payment->update(['status' => 'failed']);
                    return ['error' => 'Unable to convert currency: ' . $th->getMessage()];
                }
            case 'mtnmomo':
                try {
                    $momoAmount = round($this->currencyConversionService->convert($payment->amount, $payment->currency, 'EUR'), 2);
                    $payment->update(['amount' => $momoAmount, 'currency' => 'EUR']);
                    return $this->mtnMomoService->initiate($payment);
                } catch (Throwable $th) {
                    $payment->update(['status' => 'failed']);
                    return ['error' => 'Unable to convert currency: ' . $th->getMessage()];
                } 
            default:
                return null;
        }
    }

    public function complete(string $method, Paymenthistory $payment, array $paymentData = [])
    {
        switch ($method) {
            case 'paypal':
                return $this->paypalService->complete($payment, $paymentData);
            case 'mtnmomo':
                return $this->mtnMomoService->complete($payment);
            default:
                return null;
        }
    }
}