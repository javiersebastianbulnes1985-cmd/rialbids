<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Rol del usuario en la plataforma
            $table->enum('role', ['admin', 'seller', 'bidder'])->default('bidder');

            // Datos personales
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 30)->nullable();
            $table->string('avatar')->nullable();

            // Datos de dirección (para envíos)
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();

            // Verificación de identidad (KYC - obligatorio para sellers)
            $table->enum('kyc_status', ['pending', 'submitted', 'approved', 'rejected'])->default('pending');
            $table->string('kyc_document_type')->nullable(); // passport, dni, etc.
            $table->string('kyc_document_front')->nullable();
            $table->string('kyc_document_back')->nullable();
            $table->timestamp('kyc_verified_at')->nullable();
            $table->text('kyc_rejection_reason')->nullable();

            // Stripe Connect (para sellers recibir pagos)
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_account_id')->nullable(); // Stripe Connect account
            $table->boolean('stripe_onboarding_complete')->default(false);

            // Estado de la cuenta
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured_seller')->default(false); // sellers destacados
            $table->text('bio')->nullable(); // descripción del seller/galería
            $table->string('business_name')->nullable(); // nombre de la joyería/galería
            $table->string('website')->nullable();

            // Estadísticas (denormalizadas para performance)
            $table->unsignedInteger('total_auctions_won')->default(0);
            $table->unsignedInteger('total_auctions_sold')->default(0);
            $table->decimal('total_spent', 15, 2)->default(0);
            $table->decimal('total_earned', 15, 2)->default(0);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('role');
            $table->index('kyc_status');
            $table->index('stripe_account_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
