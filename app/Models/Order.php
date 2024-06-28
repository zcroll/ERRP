<?php

namespace App\Models;

use App\Enums\OrderType;
use App\Events\OrderStatusChangedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;


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
    /**
     * @var mixed|string
     */



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

    public function calculateTotal(): static
    {
        $total = $this->orderItems->sum(function ($orderItem) {
            return $orderItem->quantity * $orderItem->product->unit_price;
        });

        $this->total_price = $total;
        return $this;
    }



    public function calculateEarningsAndLosses()
    {
        Log::info('calculateEarningsAndLosses called for Order ID: ' . $this->id);

        $earnings = 0;
        $losses = 0;

        Log::info('Current Order Status: ' . $this->status);

        if ($this->status === 'delivered') {
            $earnings = $this->total_price * 0.1;
        } elseif ($this->status === 'returned') {
            $losses = $this->total_price * 0.05;
        }

        Log::info('Earnings: ' . $earnings . ', Losses: ' . $losses);
//ds();
        $record = EarningsLosses::updateOrCreate(
            ['order_id' => $this->id],
            [
                'earnings' => $earnings,
                'losses' => $losses,
                'final_cost' =>$earnings-$losses
            ]
        );

        Log::info('EarningsLosses record updated/created: ' . $record->toJson());
    }


    public static function boot(): void
    {
        parent::boot();

        static::updated(function (Order $order) {
            Log::info('Order updated with ID: ' . $order->id . ' and status: ' . ($order->status ?? 'null'));
            if (in_array($order->status, ['delivered', 'returned'])) {
                $order->calculateEarningsAndLosses();
            }
        });

        static::created(function (Order $order) {
            Log::info('Order created with ID: ' . $order->id . ' and status: ' . ($order->status ?? 'null'));
            if (in_array($order->status, ['delivered', 'returned'])) {
                $order->calculateEarningsAndLosses();
            }
        });
    }


    public function getCustomerAndVendorAttribute(): string
    {
        $customerName = $this->customer->personalInfo?->first_name ?? " ";
        $vendorName = $this->vendor?->business_name ?? " ";
//         ds($customerName , $vendorName);
        return $customerName && $vendorName
            ? $customerName .''. $vendorName
            : '-';
    }


}
