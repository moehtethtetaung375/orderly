<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            
            'status' => [
                'required',
                request()->user()->role === 'admin'
                    ? 'in:pending,processing,completed,cancelled'
                    : 'in:pending,cancelled',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*' => [
                'required',
                'array',
            ],

            'items.*.selected' => [
                'nullable',
                'accepted',
            ],

            'items.*.quantity' => [
                'required_if:items.*.selected,1',
                'nullable',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' =>
                'Please select an order status.',

            'status.in' =>
                'Please select a valid order status.',

            'items.required' =>
                'Please select at least one food item.',

            'items.min' =>
                'Please select at least one food item.',

            'items.*.quantity.required_if' =>
                'Please enter the quantity for each selected item.',

            'items.*.quantity.integer' =>
                'Quantity must be a whole number.',

            'items.*.quantity.min' =>
                'Quantity must be at least 1.',
        ];
    }
}
