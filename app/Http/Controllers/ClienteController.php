<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Mostrar todos los clientes
    public function index()
    {
        // Obtener el ID del usuario autenticado
        $usuarioId = auth()->user()->id;
    
        // Devolver solo los clientes asociados a este usuario
        return Cliente::where('usuario_id', $usuarioId)->get();
    }

    // Crear un nuevo cliente
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|max:250',
            'rif' => 'required|max:250',
            'direccion' => 'required|max:50',
            'telefono' => 'required|max:50',
            'vendedor' => 'required|max:250',
        ]);
    
        // Aquí obtienes el ID del usuario autenticado
        $usuarioId = auth()->user()->id;
    
        // Creas el nuevo cliente con los datos del request y agregas el usuario_id
        $cliente = Cliente::create(array_merge($request->all(), ['usuario_id' => $usuarioId]));
    
        return response()->json($cliente, 201);
    }

    // Mostrar un cliente específico
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        return $cliente;
    }

    // Actualizar un cliente
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        $this->validate($request, [
            'nombre' => 'max:250',
            'rif' => 'max:250',
            'direccion' => 'max:50',
            'telefono' => 'max:50',
            'vendedor' => 'max:250',
        ]);

        $cliente->update($request->all());

        return response()->json($cliente, 200);
    }

    // Eliminar un cliente
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['mensaje' => 'Cliente eliminado'], 200);
    }
}
