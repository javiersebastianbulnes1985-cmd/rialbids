<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('status');
            $table->timestamp('shipped_at')->nullable()->after('tracking_number');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->timestamp('payment_released_at')->nullable()->after('delivered_at');
            $table->string('stripe_transfer_id')->nullable()->after('payment_released_at');
        });

        // Agregar nuevos valores al enum status
        DB::statement("ALTER TABLE auctions MODIFY COLUMN status ENUM('draft','pending','approved','active','finished','paid','shipped','delivered','completed','cancelled','failed') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn(['tracking_number','shipped_at','delivered_at','payment_released_at','stripe_transfer_id']);
        });

        DB::statement("ALTER TABLE auctions MODIFY COLUMN status ENUM('draft','pending','approved','active','finished','paid','cancelled','failed') NOT NULL DEFAULT 'draft'");
    }
};
