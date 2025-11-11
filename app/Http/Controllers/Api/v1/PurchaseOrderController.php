<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\PurchaseOrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\PurchaseOrder;
use App\Services\PurchaseOrderService;

class PurchaseOrderController extends Controller
{
    public function __construct(protected PurchaseOrderService $purchaseOrderService)
    {
    }

    public function store(StorePurchaseOrderRequest $request)
    {
        $purchaseOrder = $this->purchaseOrderService->create($request->validated());

        return response()->json($purchaseOrder, 201);
    }

    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        if ($request->has('status')) {
            $status = PurchaseOrderStatus::from($request->input('status'));
            if ($status === PurchaseOrderStatus::PENDING) {
                $purchaseOrder = $this->purchaseOrderService->submit($purchaseOrder);
            } elseif ($status === PurchaseOrderStatus::CANCELLED) {
                $purchaseOrder = $this->purchaseOrderService->reject($purchaseOrder);
            } else {
                $purchaseOrder->update($request->validated());
            }
        } else {
            $purchaseOrder->update($request->validated());
        }

        return response()->json($purchaseOrder);
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder = $this->purchaseOrderService->approve($purchaseOrder);

        return response()->json($purchaseOrder);
    }

    public function reject(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder = $this->purchaseOrderService->reject($purchaseOrder);

        return response()->json($purchaseOrder);
    }

    public function history(PurchaseOrder $purchaseOrder)
    {
        $history = $this->purchaseOrderService->getHistory($purchaseOrder);

        return response()->json($history);
    }
}
