<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visita_parcelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorrido_id')->constrained('recorrido_tecnicos')->cascadeOnDelete();
            $table->foreignId('parcela_id')->constrained('parcelas')->cascadeOnDelete();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('cultivo_id')->nullable()->constrained('cultivos')->nullOnDelete();
            $table->foreignId('zafra_id')->nullable()->constrained('zafras')->nullOnDelete();
            $table->enum('tipo_visita', ['RECOMENDACION', 'MONITOREO'])->default('MONITOREO');
            $table->enum('estado_general', ['ok', 'warn', 'bad'])->default('ok');
            $table->enum('estado_plagas', ['ok', 'warn', 'bad'])->default('ok');
            $table->enum('estado_enfermedades', ['ok', 'warn', 'bad'])->default('ok');
            $table->enum('estado_humedad', ['ok', 'warn', 'bad'])->default('ok');
            $table->text('observacion_tecnico')->nullable();
            $table->text('observacion_productor')->nullable();
            $table->string('tipo_aplicacion', 100)->nullable();
            $table->string('variedad_observada', 100)->nullable();
            $table->decimal('hectareas_aplicadas', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visita_parcelas');
    }
};
