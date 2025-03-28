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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Имя пользователя
            $table->string('email')->unique(); // Email (уникальный)
            $table->string('password'); // Пароль
            $table->string('language')->default('en'); // Язык пользователя (по умолчанию "en")
            $table->foreignId('preferred_currency_id')->nullable()->constrained('currencies')->nullOnDelete(); // Предпочитаемая валюта
            $table->boolean('is_active')->default(true); // Активность пользователя
            $table->timestamp('email_verified_at')->nullable(); // Подтверждение email
            $table->rememberToken(); // Токен для "запомнить меня"
            $table->timestamps();
            $table->softDeletes(); // Мягкое удаление
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
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
