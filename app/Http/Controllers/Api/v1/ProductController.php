<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page  = $request->page ?? 1;
        $limit = $request->limit ?? 10;

        $query = Product::query();

        $total = $query->count();
        $rows  = $query->skip(($page - 1) * $limit)->take($limit)->get();

        return response()->json([
            'rows'  => $rows,
            'total' => $total
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'code'        => $request->code,
            'name'        => $request->name,
            'sku'         => $request->sku,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully!',
            'data'    => $product,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data'    => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
            'code'        => $request->code,
            'name'        => $request->name,
            'sku'         => $request->sku,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully!',
            'data'    => $product,
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
            'message' => 'Product deleted successfully!',
        ]);
    }
}
