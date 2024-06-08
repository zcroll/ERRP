<?php

namespace App\Models;

use App\Enums\OrderType;
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
        'payment_id',
        'vendor_id',
        'type',


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
        'vendor_id' => 'integer',
        'payment_method_id' => 'integer',
//        'type' => OrderType::class
    ];


    public static function boot()
    {
        parent::boot();

        static::updated(function (Order $order) {
            if ($order->status === 'shipped' || $order->status === 'returned') {
                $order->calculateEarningsAndLosses();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
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

    public function calculateEarningsAndLosses(): void
    {
        if ($this->status === 'shipped') {
            $earnings = 0;
            $losses = 0;

            foreach ($this->orderItems as $orderItem) {
                $product = $orderItem->product;
                $unitPrice = $product->unit_price;
                $cost = $product->cost;
                $quantity = $orderItem->quantity;

                $earnings += ($unitPrice - $cost) * $quantity;

            }

            $earningsLosses = new EarningsLosses();
            $earningsLosses->order_id = $this->id;
            $earningsLosses->earnings = $earnings;
            $earningsLosses->losses = 0;

            $earningsLosses->save();
        } elseif ($this->status === 'returned') {
            $losses = 0;

            foreach ($this->orderItems as $orderItem) {
                $product = $orderItem->product;
                $cost = $product->cost;
                $quantity = $orderItem->quantity;

                $losses += $cost * $quantity;
            }

            $earningsLosses = new EarningsLosses();
            $earningsLosses->order_id = $this->id;
            $earningsLosses->earnings = 0;
            $earningsLosses->losses = $losses;
            $earningsLosses->save();
        }
    }



    public function getCustomerAndVendorAttribute(): string
    {
        $customerName = $this->customer->personalInfo?->first_name ?? " ";
        $vendorName = $this->vendor?->business_name ?? " ";
         ds($customerName , $vendorName);
        return $customerName && $vendorName
            ? $customerName .''. $vendorName
            : '-';
    }


}
