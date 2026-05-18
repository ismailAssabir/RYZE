<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:stripe,paypal,cod',
            'coupon_code' => 'nullable|string|max:50',
            'shipping_address.name' => 'required|string|max:120',
            'shipping_address.email' => 'required|email',
            'shipping_address.phone' => 'required|string|max:30',
            'shipping_address.address' => 'required|string|max:255',
            'shipping_address.city' => 'required|string|max:120',
            'shipping_address.postal_code' => 'nullable|string|max:30',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
