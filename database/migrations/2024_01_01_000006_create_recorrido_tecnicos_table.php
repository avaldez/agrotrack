<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recorrido_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_recorrido');
            $table->foreignId('creado_por_user_id')->constrained('users')->cascadeOnDelete();
            $table->text('observacion_general')->nullable();
            $table->boolean('finalizado')->default(false);
            $table->timestamps();
        });

        Schema::create('recorrido_tecnico_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorrido_id')->constrained('recorrido_tecnicos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['recorrido_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recorrido_tecnico_user');
        Schema::dropIfExists('recorrido_tecnicos');
    }
};
