<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\InvoiceDTO;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService $invoiceService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return new JsonResponse(
                data: $this->invoiceService->getAllInvoices(),
                status: ResponseAlias::HTTP_OK
            );
        } catch (Throwable $th) {
            return new JsonResponse(
                data: ['error' => 'Request error', 'message' => $th->getMessage()],
                status: ResponseAlias::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        try {
            $dto = InvoiceDTO::fromRequest($request);
            $invoice = $this->invoiceService->createInvoice($dto);

            return new JsonResponse(
                data: ['data' => $invoice],
                status: ResponseAlias::HTTP_CREATED
            );
        } catch (Throwable $th) {
            return new JsonResponse(
                data: ['error' => 'Request error', 'message' => $th->getMessage()],
                status: ResponseAlias::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            return new JsonResponse(
                data: $this->invoiceService->getInvoice($id),
                status: ResponseAlias::HTTP_OK
            );
        } catch (Throwable $th) {
            return new JsonResponse(
                data: ['error' => 'Not found', 'message' => $th->getMessage()],
                status: ResponseAlias::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        try {
            $dto = InvoiceDTO::fromRequest($request);
            $updatedInvoice = $this->invoiceService->updateInvoice($invoice, $dto);

            return new JsonResponse(
                data: ['data' => $updatedInvoice],
                status: ResponseAlias::HTTP_OK
            );
        } catch (Throwable $th) {
            return new JsonResponse(
                data: ['error' => 'Bad request', 'message' => $th->getMessage()],
                status: ResponseAlias::HTTP_BAD_REQUEST
            );
        }
    }

}
