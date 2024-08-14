<?php

namespace App\Services;

use Omnipay\Omnipay;
use App\Models\Paymenthistory;

class PayPalService
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(config('services.paypal.client_id'));
        $this->gateway->setSecret(config('services.paypal.secret'));
        $this->gateway->setTestMode(config('services.paypal.sandbox'));
    }

    public function initiate(Paymenthistory $payment)
    {
        $response = $this->gateway->purchase([
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'description' => $payment->description,
            'returnUrl' => route('payment.success', ['method' => 'paypal', 'payment' => $payment->id]),
            'cancelUrl' => route('payment.cancel', ['method' => 'paypal', 'payment' => $payment->id]),
        ])->send();

        if ($response->isRedirect()) {
            $payment->update([
                'payment_id' => $response->getTransactionReference(),
                'status' => 'pending'
            ]);
            return ['redirectUrl' => $response->getRedirectUrl()];
        }
        // dd($response);
        $payment->update(['status' => 'failed']);
        return null;
    }

    public function complete(Transaction $transaction, array $paymentData)
    {
        $response = $this->gateway->completePurchase([
            'payer_id' => $paymentData['PayerID'],
            'transactionReference' => $paymentData['paymentId']
        ])->send();

        if ($response->isSuccessful()) {
            $paymentDetails = $response->getData();
            $transaction->update([
                'status' => 'completed',
                'payment_details' => json_encode($paymentDetails)
            ]);
            return $paymentDetails;
        }

        $transaction->update(['status' => 'failed']);
        return null;
    }
}