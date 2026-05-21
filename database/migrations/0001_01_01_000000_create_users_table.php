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
            $table->string('user_type')->default('C'); // 'C' Cliente, 'F' Funcionário, 'A' Admin
            $table->string('gender'); // 'M' ou 'F'
            $table->tinyInteger('blocked')->default(0);
            $table->string('photo_url')->nullable();
            $table->text('custom')->nullable();
            $table->timestamps(); // Cria created_at e updated_at
            $table->softDeletes(); // Cria deleted_at
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