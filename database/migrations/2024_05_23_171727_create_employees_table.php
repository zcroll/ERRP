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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 50);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->foreignId('department_id');
            $table->string('job_title', 255);
            $table->timestamp('hire_date');
            $table->decimal('salary', 8, 2);
            $table->foreignId('role_id');
            $table->foreignId('address_id');
            $table->timestamp('last_login');
            $table->string('password', 255);
            $table->timestamp('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
