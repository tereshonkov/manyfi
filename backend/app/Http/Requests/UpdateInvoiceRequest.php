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
            'net_amount' => ['required', 'numeric', 'gt:0'],
            'vat_amount' => ['required', 'numeric', 'min:0'],
            'due_date'   => ['required', 'date', 'after_or_equal:issue_date'],
            'number'          => ['sometimes', 'string'],
            'supplier_name'   => ['sometimes', 'string'],
            'supplier_tax_id' => ['sometimes', 'string'],
            'currency'        => ['sometimes', 'string', 'size:3'],
            'issue_date'      => ['sometimes', 'date'],
            'status'          => ['sometimes', 'nullable', Rule::in(['pending', 'approved', 'rejected'])],
        ];
    }
}
