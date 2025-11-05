<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'fraccionamiento',
        'distrito',
        'finca',
        'padron', 
        'cuentaCatastral',
        'manzana',
        'lote',
        'loteamiento',
        'superficie',
        'precioTotal',
        'modalidadPago',
        'cuotas',
        'montoCuota',
        'estadoVenta',
        'entregado',
        'amojonado',
        'limpio',
        'tieneConstruccion',
        'aguaPotable',
        'energiaElectrica',
        'calle',
        'seguridad',
        'beneficiosComunes',
        'requiereExpensas',
        'expensas',
        'restriccionConstrucion',
        'latitud',
        'longitud',
        'linderoNorteMedida',
        'linderoSurMedida',
        'linderoEsteMedida',
        'linderoOesteMedida',
        'linderoNorteCon',
        'linderoSurCon',
        'linderoEsteCon',
        'linderoOesteCon',
        'linderoNorteCalle',
        'linderoSurCalle',
        'linderoEsteCalle',
        'linderoOesteCalle',
        'observacion',
        'imagenes',
        'compradorId',
    ];

    protected $casts = [
        'entregado' => 'boolean',
        'amojonado' => 'boolean',
        'limpio' => 'boolean',
        'tieneConstruccion' => 'boolean',
        'aguaPotable' => 'boolean',
        'energiaElectrica' => 'boolean',
        'calle' => 'boolean',
        'seguridad' => 'boolean',
        'requiereExpensas' => 'boolean',
        'superficie' => 'decimal:2',
        'precioTotal' => 'decimal:2',
        'montoCuota' => 'decimal:2',
        'expensas' => 'decimal:2',
        'latitud' => 'decimal:6',
        'longitud' => 'decimal:6',
        'linderoNorteMedida' => 'decimal:2',
        'linderoSurMedida' => 'decimal:2',
        'linderoEsteMedida' => 'decimal:2',
        'linderoOesteMedida' => 'decimal:2',
        'beneficiosComunes' => 'array',
        'restriccionConstrucion' => 'array',
        'imagenes' => 'array',
    ];

    // Relación con Cliente (comprador)
    public function comprador()
    {
        return $this->belongsTo(Cliente::class, 'compradorId');
    }
}
