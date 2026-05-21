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
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // Não é auto-increment
            $table->string('nif', 9)->nullable();
            $table->text('address')->nullable();
            $table->string('default_payment_type')->nullable(); // Visa, PayPal, MB
            $table->string('default_payment_ref')->nullable();
            $table->text('custom')->nullable();
            $table->softDeletes(); // deleted_at

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
