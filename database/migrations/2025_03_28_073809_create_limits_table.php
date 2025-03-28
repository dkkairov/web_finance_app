<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Владелец лимита
            $table->foreignId('transaction_category_id')->constrained()->onDelete('cascade'); // Категория транзакции
            $table->decimal('amount', 18, 2); // Лимит по сумме
            $table->foreignId('currency_id')->constrained()->onDelete('cascade'); // Валюта лимита
            $table->enum('period', ['daily', 'weekly', 'monthly'])->default('monthly'); // Период лимита
            $table->boolean('is_active')->default(true); // Флаг активности
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('limits');
    }
};
