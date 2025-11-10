<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.users.index');
    }
}
