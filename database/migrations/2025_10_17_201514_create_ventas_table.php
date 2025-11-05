<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // Datos principales
            $table->decimal('montoTotal', 15, 2); // más precisión
            $table->enum('estado', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');
            $table->enum('tipoPago', ['efectivo', 'transferencia', 'credito'])->default('efectivo');

            // Información de cuotas
            $table->integer('cantidadCuotas')->nullable();
            $table->decimal('montoCuota', 15, 2)->nullable();
            $table->integer('cuotasPagadas')->default(0);

            // 💰 Campos nuevos (interés y mora)
            $table->decimal('tasaInteresMoratorio', 5, 2)->default(0.20); // porcentaje diario
            $table->decimal('multaMoraDiaria', 10, 2)->default(5000); // valor base (guaraníes, por ejemplo)

            // 📄 Comprobante y observaciones
            $table->string('comprobante')->nullable(); // nombre de archivo, URL o referencia
            $table->text('observaciones')->nullable();

            // Relaciones
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};