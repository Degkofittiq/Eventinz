<?php

namespace App\Services;

use Log;
use Exception;
use App\Models\Paymenthistory;
use Illuminate\Support\Str;
use Bmatovu\MtnMomo\Products\Collection;

class MTNMomoService
{
    private $collection;

    public function __construct()
    {
        $this->collection = new Collection();
    }

    public function initiate(Paymenthistory $payment)
    {
        try {
            $payment_id = 'trx_' . Str::uuid();
            $referenceId = $this->collection->requestToPay(
                $payment_id,
                $payment->phone_number,
                $payment->amount,
                $payment->currency,
                $payment->description
            );

            $payment->update([
                'reference' => $referenceId,
                'status' => 'pending'
            ]);

            return [
                'payment_id' => $payment_id,
                'referenceId' => $referenceId
            ];
        } catch (Exception $e) {
            Log::error('MTN MoMo payment initiation failed: ' . $e->getMessage());
            $payment->update(['status' => 'failed']);
            return null;
        }
    }

    public function complete(Paymenthistory $payment)
    {
        try {
            $paymentStatus = $this->collection->getPaymenthistoryStatus($payment->reference);
            if ($paymentStatus['status'] === 'SUCCESSFUL') {
                $payment->update([
                    'status' => 'completed',
                    'payment_details' => json_encode($paymentStatus)
                ]);
                return $paymentStatus;
            } else {
                $payment->update([
                    'status' => 'failed',
                    'payment_details' => json_encode($paymentStatus)
                ]);
                return null;
            }
        } catch (\Exception $e) {
            \Log::error('MTN MoMo payment completion check failed: ' . $e->getMessage());
            $payment->update(['status' => 'failed']);
            return null;
        }
    }
}