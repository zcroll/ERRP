<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EarningsLosses extends Model
{
    protected $fillable = [
        'order_id',
        'earnings',
        'losses',
        'final_cost'
    ];

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


}
