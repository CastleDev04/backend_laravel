<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function createClientes(Request $request)
    {
        try {
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cliente creado exitosamente',
                'cliente' => $cliente
            ], 201);

        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el cliente',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function getClientes()
    {
        try {
            $clientes = Cliente::all();

            return response()->json([
                'success' => true,
                'message' => 'Clientes obtenidos con éxito',
                'clientes' => $clientes
            ]);

        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los clientes'
            ], 500);
        }
    }

    public function getClienteById($id)
    {
        try {
            $cliente = Cliente::find($id);

            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cliente obtenido con éxito',
                'cliente' => $cliente
            ]);

        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el cliente'
            ], 500);
        }
    }

    public function updateClienteById(Request $request, $id)
    {
        try {
            $cliente = Cliente::find($id);

            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            $cliente->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Cliente actualizado con éxito',
                'cliente' => $cliente
            ]);

        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cliente'
            ], 500);
        }
    }

    public function deleteClienteById($id)
    {
        try {
            $cliente = Cliente::find($id);

            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            $cliente->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cliente eliminado con éxito'
            ]);

        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cliente'
            ], 500);
        }
    }
}