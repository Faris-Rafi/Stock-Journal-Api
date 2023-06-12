<?php

namespace App\Http\Controllers;

use App\Models\AraArbRule;
use Illuminate\Http\Request;

class AraArbRuleController extends Controller
{
    //

    public function index()
    {
        $rules = AraArbRule::where('status', 1)->get();
        
        return response()->json($rules);
    }
}
