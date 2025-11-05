<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('fraccionamiento');
            $table->string('distrito');
            $table->string('finca');
            $table->string('padron');
            $table->string('cuentaCatastral')->nullable();
            $table->string('manzana');
            $table->string('lote');
            $table->string('loteamiento');
            $table->decimal('superficie', 10, 2);
            $table->decimal('precioTotal', 12, 2);
            $table->string('modalidadPago');
            $table->integer('cuotas')->nullable();
            $table->decimal('montoCuota', 10, 2)->nullable();
            $table->string('estadoVenta');
            $table->boolean('entregado')->default(false);
            $table->boolean('amojonado')->default(false);
            $table->boolean('limpio')->default(false);
            $table->boolean('tieneConstruccion')->default(false);
            $table->boolean('aguaPotable')->default(false);
            $table->boolean('energiaElectrica')->default(false);
            $table->boolean('calle')->default(false);
            $table->boolean('seguridad')->default(false);
            $table->json('beneficiosComunes')->nullable();
            $table->boolean('requiereExpensas')->default(false);
            $table->decimal('expensas', 10, 2)->nullable();
            $table->json('restriccionConstrucion')->nullable();
            $table->decimal('latitud', 10, 6)->nullable();
            $table->decimal('longitud', 10, 6)->nullable();
            $table->decimal('linderoNorteMedida', 8, 2)->nullable();
            $table->decimal('linderoSurMedida', 8, 2)->nullable();
            $table->decimal('linderoEsteMedida', 8, 2)->nullable();
            $table->decimal('linderoOesteMedida', 8, 2)->nullable();
            $table->string('linderoNorteCon')->nullable();
            $table->string('linderoSurCon')->nullable();
            $table->string('linderoEsteCon')->nullable();
            $table->string('linderoOesteCon')->nullable();
            $table->string('linderoNorteCalle')->nullable();
            $table->string('linderoSurCalle')->nullable();
            $table->string('linderoEsteCalle')->nullable();
            $table->string('linderoOesteCalle')->nullable();
            $table->text('observacion')->nullable();
            $table->json('imagenes')->nullable();
            
            // SIN FOREIGN KEY - solo campo normal
            $table->unsignedBigInteger('compradorId')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotes');
    }
};