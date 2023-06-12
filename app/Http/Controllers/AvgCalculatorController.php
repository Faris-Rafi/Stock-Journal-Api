<?php

namespace App\Http\Controllers;

use App\Http\Resources\AvgCalculatorResource;
use App\Http\Resources\AvgCalculatorShowResource;
use App\Models\AvgCalculator;
use App\Models\AvgCalculatorDetail;
use App\Models\CustomFeeTransaction;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class AvgCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avgCalculator = AvgCalculator::with('avgCalculatorDetail', 'customFeeTransaction')
            ->where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->latest()
            ->get();
        return AvgCalculatorResource::collection($avgCalculator);
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
            'stock_name' => 'required|string',
            'fee_transaction_id' => 'required',
            'capital_limit' => 'required'
        ]);


        $data['uuid'] = Uuid::uuid4()->toString();
        $data['user_id'] = auth()->user()->id;

        if ($request->capital_limit != Null) {
            $data['capital_limit'] = str_replace(',', '', $request->capital_limit);
        }

        if ($request->desc != Null) {
            $data['desc'] = $request->desc;
        }

        AvgCalculator::create($data);

        $avgCalculator = AvgCalculator::with('avgCalculatorDetail', 'customFeeTransaction')
            ->where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->latest()
            ->get();
        return AvgCalculatorResource::collection($avgCalculator);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AvgCalculator  $avgCalculator
     * @return \Illuminate\Http\Response
     */
    public function show(AvgCalculator $avgCalculator, $uuid)
    {
        $query = $avgCalculator
            ->with('avgCalculatorDetail', 'customFeeTransaction')
            ->where('uuid', $uuid)
            ->firstOrFail();

        return new AvgCalculatorShowResource($query);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AvgCalculator  $avgCalculator
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgCalculator $avgCalculator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AvgCalculator  $avgCalculator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AvgCalculator $avgCalculator, $id)
    {
        $query = $avgCalculator->where('id', $id);

        if ($request->stock_name) {
            $data = $request->validate([
                'stock_name' => 'required|string',
            ]);

            if ($request->desc != Null) {
                $data['desc'] = $request->desc;
            }

            $query->update($data);
        }

        if ($request->target_sell != null) {
            $query->update([
                'target_sell' => str_replace(',', '', $request->target_sell)
            ]);
        }
        if ($request->is_fee_counting != null) {
            $query->update([
                'is_fee_counting' => $request->is_fee_counting
            ]);
        }

        if ($request->fee_transaction_id != null) {
            $query->update([
                'fee_transaction_id' => $request->fee_transaction_id
            ]);
        }

        if ($request->capital_limit != null) {
            $query->update([
                'capital_limit' =>  str_replace(',', '', $request->capital_limit)
            ]);
        }

        $show = $avgCalculator
            ->with('avgCalculatorDetail', 'customFeeTransaction')
            ->findOrFail($id);

        return new AvgCalculatorShowResource($show);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AvgCalculator  $avgCalculator
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgCalculator $avgCalculator, $id)
    {
        $avgCalculator->where('id', $id)->delete();
        AvgCalculatorDetail::where('avg_calculator_id', $id)->delete();
        CustomFeeTransaction::where('avg_calculator_id', $id)->delete();

        $avgCalculators =
            AvgCalculator::with('avgCalculatorDetail', 'customFeeTransaction')
            ->where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->latest()
            ->get();
        return AvgCalculatorResource::collection($avgCalculators);
    }
}
