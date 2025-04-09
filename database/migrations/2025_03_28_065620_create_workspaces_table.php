<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название рабочего пространства
            $table->string('slug')->unique(); // Должно быть!
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete(); // Важно!
            $table->boolean('is_active')->default(true); // Активность
            $table->string('type')->nullable()->default('personal');
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index(['owner_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
