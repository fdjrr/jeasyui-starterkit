<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;

        $query = ProductCategory::query();

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
        $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:product_categories,code'],
            'name' => ['required', 'string', 'max:255'],
        ], attributes: [
            'code' => 'Kode Kategori',
            'name' => 'Nama Kategori',
        ]);

        $product_category = ProductCategory::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Produk berhasil disimpan!',
            'data' => $product_category,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $product_category)
    {
        return response()->json([
            'success' => true,
            'data' => $product_category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $product_category)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:product_categories,code,'.$product_category->id],
            'name' => ['required', 'string', 'max:255'],
        ], attributes: [
            'code' => 'Kode Kategori',
            'name' => 'Nama Kategori',
        ]);

        $product_category->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Produk berhasil disimpan!',
            'data' => $product_category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Produk berhasil dihapus!',
        ]);
    }
}
