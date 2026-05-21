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
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->string('user_type')->default('C'); // Adicionado
        $table->string('gender'); // Adicionado
        $table->tinyInteger('blocked')->default(0); // Adicionado
        $table->string('photo_url')->nullable(); // Adicionado
        $table->text('custom')->nullable(); // Adicionado
        $table->timestamps();
        $table->softDeletes(); // Adicionado
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};