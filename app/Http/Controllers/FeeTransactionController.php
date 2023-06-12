<?php

namespace App\Http\Controllers;

use App\Models\FeeTransaction;
use Illuminate\Http\Request;

class FeeTransactionController extends Controller
{
    public function index() {
        $fee = FeeTransaction::where('status', 1)->get();

        return response()->json($fee);
    }
}
