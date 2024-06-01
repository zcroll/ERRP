<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use App\Models\SalesInvoice;

class GenerateSalesInvoiceListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChangedEvent $event): void
    {
        if (in_array($event->order->status, ['shipped', 'returned'])) {
            $invoice = new SalesInvoice();

            $invoice->order_id = $event->order->id;
            $invoice->customer_id = $event->order->customer_id;
            $invoice->invoice_date = date('Y-m-d H:i:s');
            $invoice->total_amount = $event->order->total_price; // assuming you have a total field in your Order

            $invoice->save();
        }
    }
}
