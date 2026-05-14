<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('nombre', 150);
            $table->decimal('superficie_ha', 10, 2)->default(0);
            $table->string('variedad', 100)->nullable();
            $table->date('fecha_siembra')->nullable();
            $table->date('fecha_cosecha')->nullable();
            $table->foreignId('cultivo_id')->nullable()->constrained('cultivos')->nullOnDelete();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};
