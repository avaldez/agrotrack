<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recomendaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visita_parcela_id')->constrained()->cascadeOnDelete();
            $table->string('titulo', 200)->nullable();
            $table->string('audio_url', 255)->nullable();
            $table->date('fecha_recomendacion');
            $table->text('sin_recomendacion_motivo')->nullable();
            $table->boolean('requiere_accion')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recomendaciones');
    }
};
