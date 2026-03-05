<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $invoice = $this->route('invoice');

        return [
            'number' => [
                'required',
                'string',
                Rule::unique('invoices', 'number')->ignore($invoice->id)
            ],
            'net_amount' => ['required', 'numeric', 'gt:0'],
            'vat_amount' => ['required', 'numeric', 'min:0'],
            'supplier_name' => ['required', 'string'],
            'supplier_tax_id' => ['required', 'string'],
            'currency' => ['required', 'string', 'size:3'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:issue_date'],
            'status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
        ];
    }
}
