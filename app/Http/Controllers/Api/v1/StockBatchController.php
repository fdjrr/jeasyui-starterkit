<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockBatch;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;

        $query = StockBatch::query()->with(['product', 'warehouse']);

        $total = $query->count();
        $rows = $query->skip(($page - 1) * $limit)->take($limit)->get();

        $stock_batches = $rows->map(fn ($stock_batch) => [
            ...$stock_batch->toArray(),
            'purchase_price_formatted' => number_format($stock_batch->purchase_price, 2, ',', '.'),
            'product_code' => $stock_batch->product?->code,
            'product' => $stock_batch->product?->name,
            'warehouse_code' => $stock_batch->warehouse?->code,
            'warehouse' => $stock_batch->warehouse?->name,
        ])->toArray();

        return response()->json([
            'rows' => $stock_batches,
            'total' => $total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch_code' => ['required', 'string', 'max:255', 'unique:stock_batches,batch_code'],
            'product_code' => ['required', 'string', 'max:255', 'exists:products,code'],
            'warehouse_code' => ['required', 'string', 'max:255', 'exists:warehouses,code'],
            'qty_in' => ['required', 'integer', 'min:0'],
            'qty_out' => ['required', 'integer', 'min:0'],
            'purchase_price' => ['required', 'integer', 'min:0'],
            'received_at' => ['required', 'date'],
            'expired_at' => ['nullable', 'date'],
        ]);

        $product = Product::query()->where('code', $request->product_code)->first();
        $warehouse = Warehouse::query()->where('code', $request->warehouse_code)->first();

        $stock_batch = StockBatch::create([
            'batch_code' => $request->batch_code,
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'qty_in' => $request->qty_in,
            'qty_out' => $request->qty_out,
            'purchase_price' => $request->purchase_price,
            'received_at' => $request->received_at,
            'expired_at' => $request->expired_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Master Stok berhasil disimpan!',
            'data' => $stock_batch,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(StockBatch $stock_batch)
    {
        return response()->json([
            'success' => true,
            'data' => $stock_batch,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockBatch $stock_batch)
    {
        $request->validate([
            'batch_code' => ['required', 'string', 'max:255', 'unique:stock_batches,batch_code,'.$stock_batch->id],
            'product_code' => ['required', 'string', 'max:255', 'exists:products,code'],
            'warehouse_code' => ['required', 'string', 'max:255', 'exists:warehouses,code'],
            'qty_in' => ['required', 'integer', 'min:0'],
            'qty_out' => ['required', 'integer', 'min:0'],
            'purchase_price' => ['required', 'integer', 'min:0'],
            'received_at' => ['required', 'date'],
            'expired_at' => ['nullable', 'date', 'after:received_at'],
        ]);

        $product = Product::query()->where('code', $request->product_code)->first();
        $warehouse = Warehouse::query()->where('code', $request->warehouse_code)->first();

        $stock_batch->update([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'qty_in' => $request->qty_in,
            'qty_out' => $request->qty_out,
            'purchase_price' => $request->purchase_price,
            'received_at' => $request->received_at,
            'expired_at' => $request->expired_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Master Stok berhasil disimpan!',
            'data' => $stock_batch,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockBatch $stock_batch)
    {
        $stock_batch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Master Stok berhasil dihapus!',
        ]);
    }
}
