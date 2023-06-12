<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AvgCalculator extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function avgCalculatorDetail() : HasMany
    {
        return $this->hasMany(AvgCalculatorDetail::class);
    }

    public function customFeeTransaction() : HasMany
    {
        return $this->hasMany(CustomFeeTransaction::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function feeTransaction() : BelongsTo
    {
        return $this->belongsTo(FeeTransaction::class);
    }
}
