<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto'); // Meta Ads, Hosting, etc
            $table->decimal('monto', 10, 2);
            $table->string('mes'); // 2026-05
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('gastos');
    }
};
