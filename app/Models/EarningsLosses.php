<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarningsLosses extends Model
{
    protected $fillable = [
        'order_id',
        'earnings',
        'losses',
        'earnings_losses'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
