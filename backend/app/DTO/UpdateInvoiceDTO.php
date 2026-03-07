<?php

declare(strict_types=1);

namespace App\DTO;

use App\Http\Requests\UpdateInvoiceRequest;
use Carbon\Carbon;

readonly class UpdateInvoiceDTO
{
    public function __construct(
        public float $net_amount,
        public float $vat_amount,
        public Carbon $due_date,
    ) {}

    public static function fromRequest(UpdateInvoiceRequest $request): self
    {
        return new self(
            net_amount: (float) $request->validated('net_amount'),
            vat_amount: (float) $request->validated('vat_amount'),
            due_date: Carbon::parse($request->validated('due_date')),
        );
    }

    public function toArray(): array
    {
        return [
            'net_amount' => $this->net_amount,
            'vat_amount' => $this->vat_amount,
            'due_date'   => $this->due_date->format('Y-m-d'),
        ];
    }
}
