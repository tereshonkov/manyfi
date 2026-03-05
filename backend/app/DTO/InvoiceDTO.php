<?php

declare(strict_types=1);

namespace App\DTO;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Carbon\Carbon;

readonly class InvoiceDTO
{
    public function __construct(
        public string $number,
        public string $supplier_name,
        public string $supplier_tax_id,
        public float $net_amount,
        public float $vat_amount,
        public string $currency,
        public Carbon $issue_date,
        public Carbon $due_date,
        public string $status,
    ) {}

    public static function fromRequest(StoreInvoiceRequest|UpdateInvoiceRequest $request): self
    {
        return new self(
            number: $request->validated('number'),
            supplier_name: $request->validated('supplier_name'),
            supplier_tax_id: $request->validated('supplier_tax_id'),
            net_amount: (float) $request->validated('net_amount'),
            vat_amount: (float) $request->validated('vat_amount'),
            currency: $request->validated('currency'),
            issue_date: Carbon::parse($request->validated('issue_date')),
            due_date: Carbon::parse($request->validated('due_date')),
            status: $request->validated('status', 'pending'),
        );
    }

    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'supplier_name' => $this->supplier_name,
            'supplier_tax_id' => $this->supplier_tax_id,
            'net_amount' => $this->net_amount,
            'vat_amount' => $this->vat_amount,
            'currency' => $this->currency,
            'issue_date' => $this->issue_date->format('Y-m-d'),
            'due_date' => $this->due_date->format('Y-m-d'),
            'status' => $this->status,
        ];
    }
}
