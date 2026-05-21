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
        Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
    $table->foreignId('tshirt_image_id')->constrained('tshirt_images');
    $table->string('color_code');
    $table->string('size'); // XS, S, M, L, XL
    $table->integer('qty');
    $table->decimal('unit_price', 8, 2);
    $table->decimal('sub_total', 10, 2);
    $table->text('custom')->nullable();
    
    $table->foreign('color_code')->references('code')->on('colors');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
