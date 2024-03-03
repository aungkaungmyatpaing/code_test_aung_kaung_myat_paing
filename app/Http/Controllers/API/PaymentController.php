<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentAccountResource;
use App\Http\Resources\PaymentMethodResource;
use App\Services\PaymentService;
use App\Traits\ApiResponse;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponse;

    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function getPaymentMethods()
    {
        $paymentMethods = $this->paymentService->getPaymentMethods();
        return $this->success("Get payment methods successfully", PaymentMethodResource::collection($paymentMethods));
    }

    public function getPaymentAccounts(int $id)
    {
        $paymentAccounts = $this->paymentService->getPaymentAccounts($id);
        return $this->success("Get payment accounts successfully", PaymentAccountResource::collection($paymentAccounts));
    }
}
