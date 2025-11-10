<?php

namespace App\Http\Controllers;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('pages.product-categories.index');
    }
}
