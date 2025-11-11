<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $rows = $request->rows ?? 10;

        $query = Product::query()
            ->with([
                'product_category',
                'product_unit',
            ])
            ->filter([
                'search' => $request->search,
                'product_category_id' => $request->product_category_id,
            ]);

        $total = $query->count();
        $rows = $query->skip(($page - 1) * $rows)->take($rows)->get();

        $products = $rows->map(fn ($product) => [
            ...$product->toArray(),
            'product_category' => $product->product_category?->name,
            'product_unit' => $product->product_unit?->name,
        ])->toArray();

        return response()->json([
            'rows' => $products,
            'total' => $total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:products,code'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'product_unit_id' => ['required', 'integer', 'exists:product_units,id'],
            'description' => ['nullable', 'string'],
        ], attributes: [
            'code' => 'Kode Produk',
            'name' => 'Nama Produk',
            'sku' => 'SKU',
            'product_category_id' => 'Kategori Produk',
            'product_unit_id' => 'Unit',
            'description' => 'Keterangan',
        ]);

        $product = Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'sku' => $request->sku,
            'product_category_id' => $request->product_category_id,
            'product_unit_id' => $request->product_unit_id,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Produk berhasil disimpan!',
            'data' => $product,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:products,code,'.$product->id],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,'.$product->id],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'product_unit_id' => ['required', 'integer', 'exists:product_units,id'],
            'description' => ['nullable', 'string'],
        ], attributes: [
            'code' => 'Kode Produk',
            'name' => 'Nama Produk',
            'sku' => 'SKU',
            'product_category_id' => 'Kategori Produk',
            'product_unit_id' => 'Unit',
            'description' => 'Keterangan',
        ]);

        $product->update([
            'code' => $request->code,
            'name' => $request->name,
            'sku' => $request->sku,
            'product_category_id' => $request->product_category_id,
            'product_unit_id' => $request->product_unit_id,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Produk berhasil <disimpan></disimpan>!',
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Produk berhasil dihapus!',
        ]);
    }
}
