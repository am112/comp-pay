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
        Schema::create('invoices', function (Blueprint $table): void {
            $table->id();
            $table->foreignUuid('tenant_id')->constrained('tenants');
            $table->foreignId('order_id')->constrained('orders');
            $table->string('type')->index(); // consent | instant | collection
            $table->string('reference_no')->unique()->index(); // generated
            $table->string('provider_no')->nullable(); // curlec refno | c2p tokenization
            $table->string('collection_no')->nullable(); // invoice no from application
            $table->string('status')->default('pending');
            $table->integer('amount')->nullable()->default(0);
            $table->string('currency')->nullable();
            $table->string('driver')->nullable();
            $table->string('batch')->nullable();
            $table->integer('retry')->nullable()->default(1);
            $table->dateTime('response_at')->nullable();
            $table->string('response_code')->nullable();
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
