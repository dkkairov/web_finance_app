<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Связь с пользователем
            $table->enum('transaction_type', ['income', 'expense', 'transfer'])->index(); // Тип операции (доход, расход, перевод)
            $table->decimal('amount', 18, 2); // Сумма операции
            $table->foreignId('transaction_category_id')->nullable()->constrained()->nullOnDelete(); // Категория транзакции
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete(); // Проект
            $table->text('description')->nullable(); // Описание
            $table->dateTime('date'); // Дата транзакции
            $table->boolean('is_active')->default(true); // Актуальна ли транзакция
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index(['user_id', 'transaction_type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
