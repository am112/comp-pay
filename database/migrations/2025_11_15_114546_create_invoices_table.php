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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->string('type')->index(); // mandate | instant | collection
            $table->string('collection_no')->nullable(); // invoice no from application
            $table->string('reference_no')->unique()->index(); // generated
            $table->string('identifier')->nullable(); // curlec refno | c2p tokenization
            $table->string('status')->default('pending');
            $table->integer('amount')->nullable()->default(0);
            $table->dateTime('response_at')->nullable();
            $table->string('driver')->nullable();
            $table->string('batch')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
