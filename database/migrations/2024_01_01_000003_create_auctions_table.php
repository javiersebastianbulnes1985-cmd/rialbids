<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete(); // el seller

            $table->foreignId('category_id')
                  ->constrained()
                  ->restrictOnDelete();

            // Información del item
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description'); // descripción general
            $table->json('technical_details')->nullable();
            // Ejemplo de technical_details para joyería:
            // {
            //   "material": "Oro 18k",
            //   "weight": "5.2g",
            //   "gemstone": "Diamante",
            //   "carat": "0.5ct",
            //   "certificate": "GIA-2025-XXXXX",
            //   "condition": "Nuevo",
            //   "year": "2024",
            //   "origin": "Argentina",
            //   "dimensions": "20x15mm"
            // }

            $table->string('condition')->nullable(); // nuevo, excelente, bueno, etc.
            $table->string('origin_country', 100)->nullable();
            $table->string('certificate_number')->nullable(); // certificado de autenticidad

            // Precios — decimal(15,2) para joyas de alto valor
            $table->decimal('starting_price', 15, 2);       // precio base de arranque
            $table->decimal('reserve_price', 15, 2)->nullable(); // precio mínimo secreto
            $table->decimal('buy_now_price', 15, 2)->nullable(); // compra inmediata
            $table->decimal('min_bid_increment', 15, 2)->default(1.00); // incremento mínimo

            // Precio actual (denormalizado para performance, se actualiza con cada puja)
            $table->decimal('current_price', 15, 2);
            $table->unsignedBigInteger('current_winner_id')->nullable(); // user_id del pujador líder
            $table->unsignedInteger('total_bids')->default(0);

            // Comisión de la plataforma para esta subasta
            $table->decimal('commission_rate', 5, 2)->default(15.00); // porcentaje

            // Tiempos
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->unsignedInteger('anti_snipe_minutes')->default(2);
            // Anti-sniping: si alguien puja en los últimos X minutos,
            // el tiempo se extiende automáticamente X minutos más

            // Estado del ciclo de vida
            $table->enum('status', [
                'draft',       // creada por el seller, sin publicar
                'pending',     // esperando aprobación del admin
                'approved',    // aprobada, esperando fecha de inicio
                'active',      // subasta en curso
                'finished',    // terminada (puede tener ganador o no)
                'cancelled',   // cancelada por admin o seller
                'failed',      // no alcanzó el precio de reserva
            ])->default('draft');

            // Datos del ganador (se llenan al finalizar)
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->decimal('final_price', 15, 2)->nullable();
            $table->timestamp('finished_at')->nullable();

            // Notas internas del admin
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            // Visibilidad y destacados
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('watchers_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Índices para queries frecuentes
            $table->index('status');
            $table->index('starts_at');
            $table->index('ends_at');
            $table->index('is_featured');
            $table->index(['status', 'ends_at']); // para listar subastas activas ordenadas por tiempo
            $table->index('current_winner_id');
            $table->index('winner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
