<?php

namespace App\Services;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

class PaymentService
{
    public function getPaymentMethods(): Collection
    {
        $paymentMethods = PaymentMethod::all();
        return $paymentMethods;
    }

    public function getPaymentAccounts(int $id): Collection
    {
        $paymentAccounts = PaymentMethod::find($id)->paymentAccounts;
        return $paymentAccounts;
    }
}
