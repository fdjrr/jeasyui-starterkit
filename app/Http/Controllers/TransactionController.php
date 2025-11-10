<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::query();

        return view('pages.transactions.index', [
            'transactions' => $transactions,
        ]);
    }
}
