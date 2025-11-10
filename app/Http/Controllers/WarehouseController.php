<?php

namespace App\Http\Controllers;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('pages.warehouses.index');
    }
}
