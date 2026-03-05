<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;


Route::middleware('api')->group(function () {
    Route::apiResource('invoices', InvoiceController::class)->only([
        'index', 'store', 'show', 'update'
    ]);
});
