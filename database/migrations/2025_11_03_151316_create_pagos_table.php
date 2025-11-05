<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');

            // Datos del pago
            $table->decimal('monto', 12, 2);
            $table->string('tipoPago'); // efectivo, transferencia, etc.
            $table->string('comprobante')->nullable(); // nombre o ruta del archivo
            $table->date('fechaPago')->default(DB::raw('CURRENT_DATE'));
            $table->decimal('interes', 12, 2)->nullable();
            $table->decimal('multa', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};