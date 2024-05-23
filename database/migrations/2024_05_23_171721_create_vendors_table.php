<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_code');
            $table->string('business_name', 100);
            $table->string('contact_name', 50);
            $table->string('contact_email', 100);
            $table->string('contact_phone', 20);
            $table->foreignId('supplier_type_id');
            $table->foreignId('supplier_rating_id');
            $table->foreignId('address_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
