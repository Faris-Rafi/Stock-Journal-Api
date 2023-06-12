<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomFeeTransaction extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function avgCalculator(): BelongsTo
    {
        return $this->belongsTo(AvgCalculator::class);
    }
}
