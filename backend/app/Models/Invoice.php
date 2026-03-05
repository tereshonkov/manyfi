<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number',
        'supplier_name',
        'supplier_tax_id',
        'net_amount',
        'vat_amount',
        'gross_amount',
        'currency',
        'status',
        'issue_date',
        'due_date',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'net_amount' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'gross_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function ($invoice) {
            $invoice->gross_amount = $invoice->net_amount + $invoice->vat_amount;
        });
    }
}
