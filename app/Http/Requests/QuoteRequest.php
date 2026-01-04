<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quote_number' => 'required|string|unique:quotes,quote_number,' . ($this->quote->id ?? ''),
            'customer_id' => 'required|exists:customers,id',
            'quote_date' => 'required|date',
            'due_date' => 'nullable|date',
            'reference' => 'nullable|string',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.tax_percentage' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.total' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'total_tax' => 'required|numeric',
            'total_discount' => 'required|numeric',
            'shipping' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric',
        ];
    }
}
