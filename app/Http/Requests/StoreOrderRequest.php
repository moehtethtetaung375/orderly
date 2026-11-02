<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.selected' => [
                'required',
                'accepted',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'status' => [
                'in:pending',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Please select at least one food item.',
            'items.array' => 'The selected food items are invalid.',
            'items.min' => 'Please select at least one food item.',

            'items.*.selected.required' => 'Please select a food item.',
            'items.*.selected.accepted' => 'Please select a food item.',

            'items.*.quantity.required' => 'Please enter the quantity.',
            'items.*.quantity.integer' => 'Quantity must be a whole number.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',

            'status.required' => 'Please select an order status.',
            'status.in' => 'The selected order status is invalid.',
        ];
    }
}
