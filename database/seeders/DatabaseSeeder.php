<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'hamid@admin.com',
            'password' => Hash::make('password')
        ]);
        $customers = Customer::factory(10)->create();
        $addresses = Address::factory(1)->create();
        $products = Product::factory(10)->create();
        $vendors = Vendor::factory(10)->create();

        $orders = Order::factory(50)->create()->each(function ($order) use ($vendors, $customers, $addresses) {
            $order->customer()->associate($customers->random());
            $order->vendor()->associate($vendors->random());
            $order->address()->associate($addresses->random());
            $order->save();
        });

        $payments = Payment::factory(10)->create()->each(function ($payment) use ($orders) {
            $payment->order()->associate($orders->random());
            $payment->save();
        });

        $orderItems = OrderItem::factory(200)->create()->each(function ($orderItem) use ($orders, $products) {
            $orderItem->order()->associate($orders->random());
            $orderItem->product()->associate($products->random());
            $orderItem->save();
        });
    }
}
