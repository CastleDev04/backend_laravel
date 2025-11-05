<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function createPago(Request $request)
    {
        $validated = $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'monto' => 'required|numeric|min:0',
            'tipoPago' => 'required|string',
            'comprobante' => 'nullable|string',
            'interes' => 'nullable|numeric',
            'multa' => 'nullable|numeric',
        ]);

        $pago = Pago::create($validated);

        // actualizar cuotas o estado de la venta si hace falta
        $venta = Venta::find($request->venta_id);
        $venta->cuotasPagadas = ($venta->cuotasPagadas ?? 0) + 1;
        if ($venta->cuotasPagadas >= $venta->cantidadCuotas) {
            $venta->estado = 'Pagada';
        }
        $venta->save();

        return response()->json([
            'success' => true,
            'message' => 'Pago registrado exitosamente',
            'pago' => $pago
        ], 201);
    }

    public function getPagos()
    {
        return response()->json([
            'success' => true,
            'pagos' => Pago::with('venta')->get()
        ]);
    }
}