<?php

namespace App\Jobs;

use AllowDynamicProperties;
use App\Models\Order;
use App\Models\PurchaseInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

#[AllowDynamicProperties]
class CreatePurchaseInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Calculate total price
        $this->order->calculateTotal();
        $this->order->save();

        // Create PurchaseInvoice
        PurchaseInvoice::create([
            'invoice_date' => now(),
            'invoice_number' => $this->order->generateInvoiceNumber(),
            'total_amount' => $this->order->total_price,
            'status' => 'pending',
            'vendor_id' => $this->order->vendor_id,
        ]);
    }
}
