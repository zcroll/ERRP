<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'unit_price',
        'order_id',
        'product_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateItemTotal(): float
    {
        return $this->quantity * $this->product->unit_price;
    }

    protected static function booted(): void
    {
        static::created(function (OrderItem $orderItem) {
            $orderItem->order->calculateTotal()->save();
        });

        static::updated(function (OrderItem $orderItem) {
            $orderItem->order->calculateTotal()->save();
        });

        static::deleted(function (OrderItem $orderItem) {
            $orderItem->order->calculateTotal()->save();
        });
    }
}
