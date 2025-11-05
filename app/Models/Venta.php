<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'montoTotal',
        'estado',
        'tipoPago',
        'cantidadCuotas',
        'montoCuota',
        'cuotasPagadas',
        'cliente_id',
        'lote_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function pagos()
{
    return $this->hasMany(Pago::class);
}
}