<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:255',
            'township_id' => 'required|integer|exists:townships,id',
            'address' => 'required|string|max:255',
            'cod' => 'required|boolean',

            'payment_account_id' => 'nullable|exists:payment_accounts,id',
            'slip' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'note' => 'nullable|string|max:255',
        ];
    }
}
