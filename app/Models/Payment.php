<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_date',
        'provider',
        'amount',
        'method'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payment_date' => 'timestamp',
        'amount' => 'decimal:2',
//        'method' => \App\Enums\PaymentMethod::class,

    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
