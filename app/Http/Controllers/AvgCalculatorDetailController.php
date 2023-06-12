<?php

namespace App\Http\Controllers;

use App\Http\Resources\AvgCalculatorShowResource;
use App\Models\AvgCalculator;
use App\Models\AvgCalculatorDetail;
use Illuminate\Http\Request;

class AvgCalculatorDetailController extends Controller
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
    public function store(Request $request, $id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AvgCalculatorDetail  $avgCalculatorDetail
     * @return \Illuminate\Http\Response
     */
    public function show(AvgCalculatorDetail $avgCalculatorDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AvgCalculatorDetail  $avgCalculatorDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgCalculatorDetail $avgCalculatorDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AvgCalculatorDetail  $avgCalculatorDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AvgCalculatorDetail $avgCalculatorDetail, $id)
    {
        $data = $request->validate([
            'price' => 'required',
            'lot' => 'required',
            'action_type' => 'required',
        ]);

        $data['price'] = str_replace(',', '', $request->price);
        $data['lot'] = str_replace(',', '', $request->lot);
        $data['avg_calculator_id'] = $id;

        $avgCalculatorDetail->create($data);

        $show = AvgCalculator::with('avgCalculatorDetail', 'customFeeTransaction')
            ->findOrFail($id);

        return new AvgCalculatorShowResource($show);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AvgCalculatorDetail  $avgCalculatorDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgCalculatorDetail $avgCalculatorDetail, $id)
    {
        $calcID = $avgCalculatorDetail->where('id', $id)->value('avg_calculator_id');
        $avgCalculatorDetail->where('id', $id)->delete();

        $show = AvgCalculator::with('avgCalculatorDetail', 'customFeeTransaction')
            ->findOrFail($calcID);

        return new AvgCalculatorShowResource($show);
    }
}
