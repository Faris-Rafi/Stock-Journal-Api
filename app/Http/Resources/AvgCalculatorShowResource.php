<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvgCalculatorShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'stock_name' => $this->stock_name,
            'capital_limit' => $this->capital_limit,
            'is_fee_counting' => $this->is_fee_counting,
            'fee_transaction_id' => $this->fee_transaction_id,
            'target_sell' => $this->target_sell,
            'desc' => $this->desc,
            'detail' => $this->whenLoaded('avgCalculatorDetail', function () {
                return $this->avgCalculatorDetail->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'avg_calculator_id' => $detail->avg_calculator_id,
                        'price' => $detail->price,
                        'lot' => $detail->lot,
                        'action_type' => $detail->action_type,
                    ];
                });
            }),
            'custom_fee' => $this->whenLoaded('customFeeTransaction', function () {
                return $this->customFeeTransaction->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'avg_calculator_id' => $detail->avg_calculator_id,
                        'buy' => $detail->buy,
                        'sell' => $detail->sell,
                    ];
                });
            }),
        ];
    }
}
