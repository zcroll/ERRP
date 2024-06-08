<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 32)->unique();

            $table->foreignId('address_id')->nullable();
            $table->string('status', 255);
            $table->string('type',255 );
            $table->decimal('total_price', 20, 2)->default('00.00');
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
