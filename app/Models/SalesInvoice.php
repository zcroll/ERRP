<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_date',
        'invoice_number',
        'total_amount',
        'status',
        'order_id',
        'total_earnings',
        'total_losses',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'invoice_date' => 'timestamp',
        'total_amount' => 'decimal:2',
        'order_id' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


    public function calculateEarningsAndLosses()
    {
        $earnings = 0;
        $losses = 0;

        $order = $this->order;


        foreach ($order as $item) {
            if ($item->status === 'delivered') {
                $earnings += ($item->unit_price - $item->product->cost) * $item->qty;
            } elseif ($item->status === 'returned') {
                $losses += $item->product->cost * $item->quantity;
            }
        }

        $this->total_earnings = $earnings;
        $this->total_losses = $losses;
        $this->save();
    }

}
