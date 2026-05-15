<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla de pagos / escrow
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('auction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();

            // Montos
            $table->decimal('amount', 15, 2);           // monto total que paga el comprador
            $table->decimal('commission', 15, 2);        // comisión de la plataforma
            $table->decimal('seller_amount', 15, 2);     // lo que recibe el seller

            // Stripe
            $table->string('stripe_payment_intent_id')->unique();
            $table->string('stripe_transfer_id')->nullable(); // transferencia al seller
            $table->string('stripe_charge_id')->nullable();

            // Estado del escrow
            $table->enum('status', [
                'pending',           // esperando pago del ganador
                'authorized',        // pago autorizado pero no capturado (hold)
                'captured',          // dinero capturado, en escrow
                'shipped',           // seller confirmó envío
                'delivered',         // comprador confirmó recepción
                'released',          // dinero liberado al seller
                'disputed',          // disputa abierta
                'refunded',          // reembolsado al comprador
                'cancelled',         // cancelado
            ])->default('pending');

            // Tracking del envío
            $table->string('tracking_number')->nullable();
            $table->string('shipping_carrier')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('released_at')->nullable();

            // Fechas límite
            $table->timestamp('payment_due_at')->nullable();  // plazo para pagar
            $table->timestamp('release_due_at')->nullable();  // auto-release si no hay disputa

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('stripe_payment_intent_id');
        });

        // Tabla de watchers (usuarios que siguen una subasta)
        Schema::create('auction_watchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['auction_id', 'user_id']);
        });

        // Tabla de notificaciones de subasta
        Schema::create('auction_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('auction_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'outbid',           // te superaron
                'auction_ending',   // subasta por terminar
                'auction_won',      // ganaste
                'auction_lost',     // perdiste
                'payment_due',      // tenés que pagar
                'item_shipped',     // tu item fue enviado
                'item_delivered',   // confirmación de entrega
                'new_bid',          // nueva puja en tu subasta (para sellers)
            ]);
            $table->boolean('is_read')->default(false);
            $table->json('data')->nullable(); // datos extra de la notificación
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
            $table->index('auction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_notifications');
        Schema::dropIfExists('auction_watchers');
        Schema::dropIfExists('payments');
    }
};
