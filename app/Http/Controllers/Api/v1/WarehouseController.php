<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;

        $query = Warehouse::query()
            ->filter([
                'search' => $request->search,
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
            'code' => ['required', 'string', 'max:255', 'unique:warehouses,code'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
        ], attributes: [
            'code' => 'Kode Gudang',
            'name' => 'Nama Gudang',
            'address' => 'Alamat',
        ]);

        $warehouse = Warehouse::query()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Gudang berhasil disimpan!',
            'data' => $warehouse,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        return response()->json([
            'success' => true,
            'data' => $warehouse,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:warehouses,code,'.$warehouse->id],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
        ]);

        $warehouse->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Gudang berhasil disimpan!',
            'data' => $warehouse,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Gudang berhasil dihapus!',
        ]);
    }
}
