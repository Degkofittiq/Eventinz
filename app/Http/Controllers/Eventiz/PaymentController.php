<?php

namespace App\Http\Controllers\Api;

// use App\Models\Credit;
use App\Models\CreditPrice;
use App\Models\Paymenthistory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PaymentService;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\CurrencyConversionService;

class PaymentController extends Controller
{
    private $paymentService;
    private $currencyConversionService;

    public function __construct(PaymentService $paymentService, CurrencyConversionService $currencyConversionService)
    {
        $this->paymentService = $paymentService;
        $this->currencyConversionService = $currencyConversionService;
    }

    public function initiatePayment(Request $request)
    {
        $user = auth()->user();
        $credits = $request->input('credits');
        $amount = $this->calculateAmount($credits);
        $method = $request->input('method');
        $currency = $request->input('currency', 'XOF');

        $payment = Paymenthistory::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'currency' => $currency,
            'description' => 'Credit Purchase',
            'phone_number_or_email' => $request->input('phoneNumber'),
            'paymentmethod' => $method,
            'payment_id' => Str::uuid(),
            'status' => 'initiated'
        ]);

        $result = $this->paymentService->initiate($method, $payment);

        if ($result) {
            if ($method === 'mtnmomo') {
                // dd($result);
                return response()->json([
                    'status' => 'pending',
                    'message' => 'Payment initiated. Please check your phone to approve the payment.',
                    'paymentId' => $result['paymentId'],
                    'referenceId' => $result['referenceId']
                ]);
            } else {
                return response()->json($result);
            }
        }

        return response()->json(['error' => 'Failed to initiate payment'], 400);
    }

    public function checkMoMoStatus(Request $request)
    {
        // dd($request);
        $paymentId = $request->input('referenceId');
        $payment = Paymenthistory::where('reference',$paymentId)
            ->where('status', 'pending')
            ->firstOrFail();
            
        $referenceId = $request->input('referenceId');
        $result = $this->paymentService->complete('mtnmomo', $payment, ['referenceId' => $referenceId]);

        if ($result) {
            $user = $payment->user;
            $amount = $result['amount'];
            $credits = $this->calculateCredits($amount);
            $payment->update([
                'amount' => $this->updateAmount($amount)
            ]);
            $user->credits += $credits;
            $user->save();
            
            return response()->json([
                'status' => 'success', 
                'message' => 'Payment successful!',
                'creditsAdded' => $credits,
                'totalCredits' => $user->credits
            ]);
        }

        return response()->json(['status' => 'pending', 'message' => 'Payment still processing']);
    }

    public function paymentSuccess(Request $request, $method)
    {
        $payment = Paymenthistory::where('id', $request->input('payment'))->where('status', 'pending')->firstOrFail();

        if ($payment) {
            $result = $this->paymentService->complete($method, $payment, $request->all());

            if ($result) {
                $credits = $this->calculateCredits($result['payments'][0]['amount']['total']);
                $this->updateUserCredits($payment->user, $credits);
        
                // Redirect to Angular app with query parameters
                $queryParams = http_build_query([
                    'status' => 'success',
                    'message' => 'credit purchased',
                    'creditsAdded' => $credits,
                    'totalCredits' => $payment->user->credits,
                    'date' => $payment->created_at->format('Y-m-d'),
                ]);
                
                return redirect()->away("http://localhost:4200/payment-completion?" . $queryParams);
            }
        }
        

        $queryParams = http_build_query([
            'status' => 'error',
            'message' => 'Payment failed'
        ]);
        
        return redirect()->away("http://localhost:4200/payment-completion?" . $queryParams);
    
    }

    public function paymentCancel($method)
    {
        return response()->json([
            "message" => "Payment cancelled."
        ]);
    }

    private function calculateAmount($credits)
    {
        $pricePerCredit = CreditPrice::orderBy('credits')->first();
        return (int)($credits * $pricePerCredit->price);
    }

    private function updateAmount($amount)
    {
        $pricePerCredit = CreditPrice::orderBy('credits')->first();
        $cfa_amount = $this->currencyConversionService->convert($amount, 'EUR', 'XOF');
        return $cfa_amount / $pricePerCredit->credits;
    }

    private function calculateCredits($amount)
    {
        $cfa_amount = round($this->currencyConversionService->convert($amount, 'EUR', 'XOF'), 2);
        $pricePerCredit = CreditPrice::orderBy('credits')->first();
        return (int) ($cfa_amount / $pricePerCredit->price) + 1;
    }

    private function updateUserCredits($user, $credits)
    {
        $user->credits += $credits;
        $user->save();
    }
}