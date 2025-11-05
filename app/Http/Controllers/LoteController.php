<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoteController extends Controller
{
    public function createPropiedad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fraccionamiento' => 'required|string|max:255',
            'distrito' => 'required|string|max:255',
            'superficie' => 'required|numeric|min:0',
            'finca' => 'nullable|string|max:255',
            'padron' => 'nullable|string|max:255',
            'cuentaCatastral' => 'nullable|string|max:255',
            'manzana' => 'nullable|string|max:255',
            'lote' => 'nullable|string|max:255',
            'loteamiento' => 'nullable|string|max:255',
            'precioTotal' => 'nullable|numeric|min:0',
            'modalidadPago' => 'nullable|string|max:255',
            'cuotas' => 'nullable|integer|min:0',
            'montoCuota' => 'nullable|numeric|min:0',
            'estadoVenta' => 'nullable|string|max:255',
            'entregado' => 'nullable|boolean',
            'amojonado' => 'nullable|boolean',
            'limpio' => 'nullable|boolean',
            'tieneConstruccion' => 'nullable|boolean',
            'aguaPotable' => 'nullable|boolean',
            'energiaElectrica' => 'nullable|boolean',
            'calle' => 'nullable|boolean',
            'seguridad' => 'nullable|boolean',
            'beneficiosComunes' => 'nullable|array',
            'requiereExpensas' => 'nullable|boolean',
            'expensas' => 'nullable|numeric|min:0',
            'restriccionConstrucion' => 'nullable|array',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'linderoNorteMedida' => 'nullable|numeric|min:0',
            'linderoSurMedida' => 'nullable|numeric|min:0',
            'linderoEsteMedida' => 'nullable|numeric|min:0',
            'linderoOesteMedida' => 'nullable|numeric|min:0',
            'linderoNorteCon' => 'nullable|string|max:255',
            'linderoSurCon' => 'nullable|string|max:255',
            'linderoEsteCon' => 'nullable|string|max:255',
            'linderoOesteCon' => 'nullable|string|max:255',
            'linderoNorteCalle' => 'nullable|string|max:255',
            'linderoSurCalle' => 'nullable|string|max:255',
            'linderoEsteCalle' => 'nullable|string|max:255',
            'linderoOesteCalle' => 'nullable|string|max:255',
            'observacion' => 'nullable|string',
            'imagenes' => 'nullable|array',
            'compradorId' => 'nullable|integer', // SIN exists validation por ahora
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();

            // Verificar si existe el comprador (si se proporcionó)
            if (!empty($data['compradorId'])) {
                $clienteExists = Cliente::where('id', $data['compradorId'])->exists();
                if (!$clienteExists) {
                    $data['compradorId'] = null; // Si no existe, establecer como null
                }
            }

            // Convertir arrays a JSON
            if (isset($data['beneficiosComunes']) && is_array($data['beneficiosComunes'])) {
                $data['beneficiosComunes'] = json_encode($data['beneficiosComunes']);
            }
            
            if (isset($data['restriccionConstrucion']) && is_array($data['restriccionConstrucion'])) {
                $data['restriccionConstrucion'] = json_encode($data['restriccionConstrucion']);
            }
            
            if (isset($data['imagenes']) && is_array($data['imagenes'])) {
                $data['imagenes'] = json_encode($data['imagenes']);
            }

            // Crear el lote
            $lote = Lote::create($data);

            // Cargar relación con comprador si existe
            if ($lote->compradorId) {
                $lote->load('comprador');
            }

            return response()->json([
                'message' => 'Propiedad creada correctamente',
                'propiedad' => $lote
            ], 201);

        } catch (\Exception $err) {
            \Log::error($err);
            return response()->json([
                'message' => 'Error al crear la propiedad',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function getPropiedades(Request $request)
    {
        try {
            $lotes = Lote::with('comprador')->get();
            
            return response()->json($lotes);

        } catch (\Exception $err) {
            \Log::error($err);
            return response()->json([
                'message' => 'Error al obtener las propiedades'
            ], 500);
        }
    }

    public function getPropiedadById($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'ID inválido'
            ], 400);
        }

        try {
            $lote = Lote::with('comprador')->find($id);

            if (!$lote) {
                return response()->json([
                    'message' => 'Propiedad no encontrada'
                ], 404);
            }

            return response()->json($lote);

        } catch (\Exception $err) {
            \Log::error($err);
            return response()->json([
                'message' => 'Error al obtener la propiedad'
            ], 500);
        }
    }

    public function updatePropiedadById(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'ID inválido'
            ], 400);
        }

        try {
            $lote = Lote::find($id);

            if (!$lote) {
                return response()->json([
                    'message' => 'Propiedad no encontrada'
                ], 404);
            }

            $data = $request->all();

            // Verificar si existe el comprador (si se proporcionó)
            if (!empty($data['compradorId'])) {
                $clienteExists = Cliente::where('id', $data['compradorId'])->exists();
                if (!$clienteExists) {
                    $data['compradorId'] = null; // Si no existe, establecer como null
                }
            }

            // Convertir arrays a JSON
            if (isset($data['beneficiosComunes']) && is_array($data['beneficiosComunes'])) {
                $data['beneficiosComunes'] = json_encode($data['beneficiosComunes']);
            }
            
            if (isset($data['restriccionConstrucion']) && is_array($data['restriccionConstrucion'])) {
                $data['restriccionConstrucion'] = json_encode($data['restriccionConstrucion']);
            }
            
            if (isset($data['imagenes']) && is_array($data['imagenes'])) {
                $data['imagenes'] = json_encode($data['imagenes']);
            }

            $lote->update($data);
            $lote->load('comprador');

            return response()->json([
                'message' => 'Propiedad actualizada correctamente',
                'propiedad' => $lote
            ]);

        } catch (\Exception $err) {
            \Log::error($err);
            return response()->json([
                'message' => 'Error al actualizar la propiedad'
            ], 500);
        }
    }

    public function deletePropiedadById($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'ID inválido'
            ], 400);
        }

        try {
            $lote = Lote::find($id);

            if (!$lote) {
                return response()->json([
                    'message' => 'Propiedad no encontrada'
                ], 404);
            }

            $lote->delete();

            return response()->json([
                'message' => 'Propiedad eliminada correctamente'
            ]);

        } catch (\Exception $err) {
            \Log::error($err);
            
            // Manejar caso específico cuando el registro no existe
            if (str_contains($err->getMessage(), 'No query results')) {
                return response()->json([
                    'message' => 'Propiedad no encontrada'
                ], 404);
            }
            
            return response()->json([
                'message' => 'Error al eliminar la propiedad'
            ], 500);
        }
    }
}