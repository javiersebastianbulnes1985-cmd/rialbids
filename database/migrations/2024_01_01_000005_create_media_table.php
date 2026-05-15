<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // morphs() crea automáticamente mediable_type, mediable_id
            // Y su índice compuesto — NO agregar índice manual sobre estos campos
            $table->morphs('mediable');

            // Archivo
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_url');
            $table->string('disk')->default('public');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size')->default(0);

            // Tipo de media
            $table->enum('type', [
                'image',
                'video',
                'document',
            ])->default('image');

            // Colección
            $table->string('collection')->default('gallery');

            // URLs optimizadas
            $table->string('thumbnail_url')->nullable();
            $table->string('medium_url')->nullable();
            $table->string('large_url')->nullable();

            // Dimensiones originales
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            // Metadatos
            $table->json('metadata')->nullable();

            // Orden y estado
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);

            // SEO
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();

            $table->timestamps();

            // Solo índices sobre columnas propias (NO sobre mediable_type/mediable_id)
            $table->index('collection');
            $table->index('type');
            $table->index('is_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
