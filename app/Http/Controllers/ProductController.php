<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductUnit;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.products.index', [
            'product_categories' => ProductCategory::all(),
            'product_units' => ProductUnit::all(),
        ]);
    }
}
