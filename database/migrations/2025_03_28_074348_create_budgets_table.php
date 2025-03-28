<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('workspace_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('transaction_category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 18, 2);
            $table->foreignId('currency_id')->constrained()->onDelete('cascade');
            $table->enum('period', ['daily', 'weekly', 'monthly'])->default('monthly');
            $table->boolean('is_active')->default(true); // Актуальна ли транзакция
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
