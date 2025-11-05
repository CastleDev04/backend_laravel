<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function createVenta(Request $request)
    {
        $request->validate([
            'montoTotal' => 'required|numeric',
            'estado' => 'required|string',
            'tipoPago' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
            'lote_id' => 'required|exists:lotes,id'
        ]);

        $venta = Venta::create($request->all());

        return response()->json([
            'message' => 'Venta creada exitosamente',
            'venta' => $venta
        ], 201);
    }

    public function getVentas()
    {
        $ventas = Venta::with(['cliente', 'lote'])->get();
        return response()->json([
            'message' => 'Ventas obtenidas con éxito',
            'ventas' => $ventas
        ]);
    }

    public function getVentaById($id)
    {
        $venta = Venta::with(['cliente', 'lote'])->find($id);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        return response()->json([
            'message' => 'Venta obtenida con éxito',
            'venta' => $venta
        ]);
    }

    public function updateVentaById(Request $request, $id)
    {
        $venta = Venta::find($id);
        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        $venta->update($request->all());

        return response()->json([
            'message' => 'Venta actualizada con éxito',
            'venta' => $venta
        ]);
    }

    public function deleteVentaById($id)
    {
        $venta = Venta::find($id);
        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        $venta->delete();

        return response()->json(['message' => 'Venta eliminada con éxito']);
    }
}