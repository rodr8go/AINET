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
    $table->string('status')->default('pending'); // pending, closed, canceled
    $table->foreignId('customer_id')->constrained('customers');
    $table->date('date');
    $table->decimal('total_price', 10, 2);
    $table->text('notes')->nullable();
    $table->text('reason_for_cancellation')->nullable();
    $table->string('nif', 9);
    $table->text('address');
    $table->string('payment_type');
    $table->string('payment_ref');
    $table->string('receipt_url')->nullable();
    $table->text('custom')->nullable();
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
