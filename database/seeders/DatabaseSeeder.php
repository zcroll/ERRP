<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $customers = Customer::factory(10)->create();
        $paymentMethods = PaymentMethod::factory(10)->create();
        $addresses = Address::factory(10)->create();
        $products = Product::factory(10)->create();

        $orders = Order::factory(50)->create()->each(function ($order) use ($customers, $paymentMethods, $addresses) {
            $order->customer_id = $customers->random()->id;
            $order->payment_method_id = $paymentMethods->random()->id;
            $order->address_id = $addresses->random()->id;
            $order->save();
        });

        $orderItems = OrderItem::factory(200)->create()->each(function ($orderItem) use ($orders, $products) {
            $orderItem->order_id = $orders->random()->id;
            $orderItem->product_id = $products->random()->id;
            $orderItem->save();
        });
    }
}
