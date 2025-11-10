<?php

namespace App\Http\Controllers;

class StockBatchController extends Controller
{
    public function index()
    {
        return view('pages.stock-batches.index');
    }
}
