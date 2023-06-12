<?php

namespace App\Http\Controllers;

use App\Models\CustomFeeTransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\AvgCalculatorShowResource;
use App\Models\AvgCalculator;
use Illuminate\Http\Request;

class CustomFeeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'buy' => 'required',
            'sell' => 'required',
        ]);

        $data['avg_calculator_id'] = $request->avg_calculator_id;
        CustomFeeTransaction::create($data);

        $show = AvgCalculator::with('avgCalculatorDetail', 'customFeeTransaction')
            ->findOrFail($request->avg_calculator_id);

        return new AvgCalculatorShowResource($show);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomFeeTransaction  $customFeeTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(CustomFeeTransaction $customFeeTransaction, $avg_calculator_id)
    {
        $fee = $customFeeTransaction->where('avg_calculator_id', $avg_calculator_id)
            ->where('status', 1)
            ->get();

        return response()->json($fee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomFeeTransaction  $customFeeTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomFeeTransaction $customFeeTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomFeeTransaction  $customFeeTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomFeeTransaction $customFeeTransaction, $avg_calculator_id)
    {
        $data = $request->validate([
            'buy' => 'required',
            'sell' => 'required',
        ]);

        $customFeeTransaction->where("avg_calculator_id", $avg_calculator_id)->update($data);

        $show = AvgCalculator::with('avgCalculatorDetail', 'customFeeTransaction')
        ->findOrFail($avg_calculator_id);

        return new AvgCalculatorShowResource($show);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomFeeTransaction  $customFeeTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomFeeTransaction $customFeeTransaction, $avg_calculator_id)
    {
        //
    }
}
