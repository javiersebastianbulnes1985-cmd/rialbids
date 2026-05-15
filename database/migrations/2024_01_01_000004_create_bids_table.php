<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();

            $table->foreignId('auction_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Monto de la puja — decimal(15,2) para joyas de alto valor
            $table->decimal('amount', 15, 2);

            // Estado de la puja
            $table->enum('status', [
                'active',    // puja vigente
                'outbid',    // superada por otra puja
                'won',       // ganadora al finalizar
                'lost',      // perdedora al finalizar
                'cancelled', // cancelada por admin
            ])->default('active');

            // Anti-sniping: registrar si esta puja extendió el tiempo
            $table->boolean('triggered_extension')->default(false);
            $table->unsignedInteger('seconds_extended')->default(0);

            // Datos técnicos para auditoría
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();

            // Puja automática (proxy bidding — como eBay)
            // El sistema puja automáticamente hasta este máximo
            $table->decimal('max_auto_bid', 15, 2)->nullable();
            $table->boolean('is_auto_bid')->default(false); // fue generada automáticamente

            $table->timestamps();

            // Índices para queries frecuentes
            $table->index('auction_id');
            $table->index('user_id');
            $table->index('status');
            $table->index(['auction_id', 'amount']); // para encontrar la puja más alta
            $table->index(['auction_id', 'created_at']); // para historial ordenado
            $table->unique(['auction_id', 'user_id', 'amount']); // evitar pujas duplicadas exactas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
