<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Владелец перевода
            $table->foreignId('from_account_id')->constrained('accounts')->onDelete('cascade'); // Откуда перевод
            $table->foreignId('to_account_id')->constrained('accounts')->onDelete('cascade'); // Куда перевод
            $table->decimal('amount', 18, 2);
            $table->foreignId('currency_id')->constrained()->onDelete('cascade'); // Валюта перевода
            $table->text('description')->nullable(); // Описание перевода
            $table->timestamp('date')->useCurrent(); // Дата перевода
            $table->boolean('is_active')->default(true);
            $table->decimal('exchange_rate', 10, 6)->nullable();
            $table->decimal('converted_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
