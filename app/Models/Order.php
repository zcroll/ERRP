<?php

namespace App\Models;

use App\Events\OrderStatusChangedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_id',
        'number',
        'total_price',
        'status',
        'shipping_address_id',
        'total_amount',
        'customer_id',
        'payment_id'

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'customer_id' => 'integer',
        'payment_method_id' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateTotal()
    {
        $total = $this->orderItems->sum(function ($orderItem) {
            return $orderItem->quantity * $orderItem->product->unit_price;
        });

        $this->total_price = $total;

        return $this;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
        $this->save();

        event(new OrderStatusChangedEvent($this));
    }
}
