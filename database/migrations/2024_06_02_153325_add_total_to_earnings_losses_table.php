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
        Schema::table('earnings_losses', function (Blueprint $table) {
            $table->integer('total')->after('losses')->nullable();
        });
    }

    public function down()
    {
        Schema::table('earnings_losses', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
};
