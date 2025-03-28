<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained()->onDelete('cascade'); // Связь с рабочим пространством
            $table->string('name'); // Название счёта
            $table->decimal('balance', 18, 2)->default(0); // Баланс
            $table->foreignId('currency_id')->constrained('currencies')->onDelete('cascade'); // Связь с валютой
            $table->boolean('is_active')->default(true); // Активен ли счёт
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index(['workspace_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
