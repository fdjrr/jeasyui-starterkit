<?php

namespace App\Services;

use App\Enums\PurchaseOrderStatus;
use App\Events\PurchaseOrderStatusChanged;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class PurchaseOrderService
{
    public function create(array $data): PurchaseOrder
    {
        return DB::transaction(function () use ($data) {
            $totalAmount = 0;

            $purchaseOrder = PurchaseOrder::create([
                'po_number'    => 'PO-' . now()->format('YmdHis') . '-' . rand(1000, 9999),
                'supplier_id'  => $data['supplier_id'],
                'order_date'   => $data['order_date'],
                'status'       => PurchaseOrderStatus::DRAFT,
                'total_amount' => 0, // Will be updated after calculating items total
                'created_by'   => $data['created_by'] ?? Auth::id(),
            ]);

            foreach ($data['items'] as $item) {
                $total = $item['quantity'] * $item['price'];
                $purchaseOrder->purchase_order_items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'total'      => $total,
                ]);
                $totalAmount  += $total;
            }

            $purchaseOrder->update(['total_amount' => $totalAmount]);

            return $purchaseOrder;
        });
    }

    public function submit(PurchaseOrder $purchaseOrder): PurchaseOrder
    {
        $purchaseOrder->update(['status' => PurchaseOrderStatus::PENDING]);
        return $purchaseOrder;
    }

    public function approve(PurchaseOrder $purchaseOrder): PurchaseOrder
    {
        dump('Before approve update:', $purchaseOrder);
        $purchaseOrder->update([
            'status'      => PurchaseOrderStatus::APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        dump('After approve update:', $purchaseOrder);
        return $purchaseOrder;
    }
    public function reject(PurchaseOrder $purchaseOrder): PurchaseOrder
    {
        $purchaseOrder->update(['status' => PurchaseOrderStatus::CANCELLED]);
        return $purchaseOrder;
    }
    public function getHistory(PurchaseOrder $purchaseOrder)
    {
        return $purchaseOrder->purchase_order_histories()->with('user')->get();
    }
}
