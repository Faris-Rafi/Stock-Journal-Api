<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvgCalculatorResource extends JsonResource
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
            'uuid' => $this->uuid,
            'stock_name' => $this->stock_name,
            'is_fee_counting' => $this->is_fee_counting,
            'fee_transaction_id' => $this->fee_transaction_id,
            'target_sell' => $this->target_sell,
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
