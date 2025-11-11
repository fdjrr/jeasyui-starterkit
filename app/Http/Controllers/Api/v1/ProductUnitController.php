<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $rows = $request->limit ?? 10;

        $query = ProductUnit::query();

        $total = $query->count();
        $rows = $query->skip(($page - 1) * $rows)->take($rows)->get();

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
        $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:product_units,code'],
            'name' => ['required', 'string', 'max:255'],
        ], attributes: [
            'code' => 'Kode Unit',
            'name' => 'Nama Unit',
        ]);

        $product_unit = ProductUnit::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Unit Produk berhasil disimpan!',
            'data' => $product_unit,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductUnit $product_unit)
    {
        return response()->json([
            'success' => true,
            'data' => $product_unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductUnit $product_unit)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:product_units,code,'.$product_unit->id],
            'name' => ['required', 'string', 'max:255'],
        ], attributes: [
            'code' => 'Kode Unit',
            'name' => 'Nama Unit',
        ]);

        $product_unit->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Unit Produk berhasil disimpan!',
            'data' => $product_unit,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductUnit $product_unit)
    {
        $product_unit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Unit Produk berhasil dihapus!',
        ]);
    }
}
