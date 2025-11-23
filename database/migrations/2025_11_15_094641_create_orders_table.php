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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique()->index(); // order No from application
            $table->string('identifier')->nullable()->index(); // curlec refno | c2p tokenization
            $table->string('status')->default('pending');
            $table->integer('amount')->nullable()->default(0);
            $table->integer('total_amount')->nullable()->default(0);
            $table->integer('paid_amount')->nullable()->default(0);
            $table->string('driver')->nullable();
            $table->string('region')->nullable();
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
