<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->enum('categoria', [
                'HERBICIDA', 'INSECTICIDA', 'FUNGICIDA',
                'FERTILIZANTE', 'ADHERENTE', 'SEMILLA', 'OTROS'
            ])->default('OTROS');
            $table->string('unidad', 20)->default('L');
            $table->decimal('dosis_referencia', 10, 3)->default(0);
            $table->decimal('precio_referencia', 12, 2)->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
