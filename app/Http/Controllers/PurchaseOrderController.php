<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return view('pages.purchase-orders.index', [
            'product_categories' => ProductCategory::all(),
        ]);
    }
}
