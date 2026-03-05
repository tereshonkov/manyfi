<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\InvoiceDTO;
use App\Models\Invoice;
use DomainException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function getAllInvoices(int $perPage = 10): LengthAwarePaginator
    {
        return Invoice::query()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getInvoice(int $id): Invoice
    {
        return Invoice::query()->findOrFail($id);
    }

    public function createInvoice(InvoiceDTO $dto): Invoice
    {
        return DB::transaction(function () use ($dto) {
            return Invoice::query()->create($dto->toArray());
        });
    }

    public function updateInvoice(Invoice $invoice, InvoiceDTO $dto): Invoice
    {
        if ($invoice->status !== 'pending') {
            throw new DomainException('Only pending invoices can be updated.');
        }
        return DB::transaction(function () use ($invoice, $dto) {
            $invoice->update($dto->toArray());
            return $invoice->fresh();
        });
    }
}
