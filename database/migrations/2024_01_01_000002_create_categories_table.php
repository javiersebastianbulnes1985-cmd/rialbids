<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Jerarquía: categoría padre (ej: Joyería) → hijo (ej: Anillos)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable(); // clase de ícono SVG o font-icon

            // Comisión específica por categoría (override de la comisión global)
            $table->decimal('commission_rate', 5, 2)->nullable(); // ej: 15.00 = 15%

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            // Estadísticas denormalizadas
            $table->unsignedInteger('total_auctions')->default(0);

            $table->timestamps();

            $table->index('parent_id');
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
