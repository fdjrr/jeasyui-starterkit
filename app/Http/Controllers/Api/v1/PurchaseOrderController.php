<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;

        $query = PurchaseOrder::query()
            ->with([
                'purchase_order_items.product',
                'purchase_order_items.warehouse',
            ]);

        $total = $query->count();
        $rows = $query->skip(($page - 1) * $limit)->take($limit)->get();

        return response()->json([
            'rows' => $rows,
            'total' => $total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:purchase_orders,code'],
            'date' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ], attributes: [
            'code' => 'Kode Order',
            'date' => 'Tanggal',
            'note' => 'Catatan',
            'items' => 'Item',
            'items.*.product_id' => 'Produk',
            'items.*.warehouse_id' => 'Gudang',
            'items.*.qty' => 'Jumlah',
        ]);

        DB::beginTransaction();

        try {
            $purchaseOrder = PurchaseOrder::query()->create([
                'code' => $validated['code'],
                'date' => $validated['date'],
                'note' => $validated['note'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $purchaseOrder->purchase_order_items()->create([
                    'product_id' => $item['product_id'],
                    'warehouse_id' => $item['warehouse_id'],
                    'qty' => $item['qty'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data Data Pembelian berhasil disimpan!',
                'data' => $purchaseOrder->load('purchase_order_items'),
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data!',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        return response()->json([
            'success' => true,
            'data' => $purchaseOrder->load([
                'purchase_order_items.product',
                'purchase_order_items.warehouse',
            ]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:purchase_orders,code,'.$purchaseOrder->id],
            'date' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ], attributes: [
            'code' => 'Kode Order',
            'date' => 'Tanggal',
            'note' => 'Catatan',
            'items' => 'Item',
            'items.*.product_id' => 'Produk',
            'items.*.warehouse_id' => 'Gudang',
            'items.*.qty' => 'Jumlah',
        ]);

        DB::beginTransaction();
        try {
            $purchaseOrder->update([
                'code' => $validated['code'],
                'date' => $validated['date'],
                'note' => $validated['note'] ?? null,
            ]);

            $purchaseOrder->purchase_order_items()->delete();

            foreach ($validated['items'] as $item) {
                $purchaseOrder->purchase_order_items()->create([
                    'product_id' => $item['product_id'],
                    'warehouse_id' => $item['warehouse_id'],
                    'qty' => $item['qty'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data Data Pembelian berhasil disimpan!',
                'data' => $purchaseOrder->load('purchase_order_items'),
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data!',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        DB::beginTransaction();

        try {
            $purchaseOrder->purchase_order_items()->delete();
            $purchaseOrder->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data Data Pembelian berhasil dihapus!',
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!',
            ], 500);
        }
    }
}
