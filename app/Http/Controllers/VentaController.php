<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    // Obtener todas las ventas
    public function index()
    {
        $ventas = Venta::with(['usuario', 'cliente', 'productos'])->get();
        return response()->json($ventas);
    }

    // Obtener una venta específica por ID
    public function show($id)
    {
        $venta = Venta::with(['usuario', 'cliente', 'productos'])->find($id);

        if (!$venta) {
            return response()->json(['mensaje' => 'Venta no encontrada'], 404);
        }

        return response()->json($venta);
    }

    // Crear una nueva venta
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'id_usuario' => 'required|exists:usuarios,id',
            'id_cliente' => 'required|exists:clientes,id',
            // Asegúrate de validar los productos si los estás enviando en la solicitud
        ]);

        $venta = new Venta();
        $venta->fecha = $request->fecha;
        $venta->total = $request->total;
        $venta->id_usuario = $request->id_usuario;
        $venta->id_cliente = $request->id_cliente;
        $venta->save();

        // Aquí deberías manejar la relación con los productos, si es necesario

        return response()->json(['mensaje' => 'Venta creada con éxito', 'venta' => $venta], 201);
    }

    // Actualizar una venta
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            // Validar otros campos si es necesario
        ]);

        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['mensaje' => 'Venta no encontrada'], 404);
        }

        $venta->fecha = $request->fecha;
        $venta->total = $request->total;
        // Actualizar otros campos si es necesario
        $venta->save();

        return response()->json(['mensaje' => 'Venta actualizada con éxito', 'venta' => $venta]);
    }

    // Eliminar una venta
    public function destroy($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['mensaje' => 'Venta no encontrada'], 404);
        }

        $venta->delete();

        return response()->json(['mensaje' => 'Venta eliminada con éxito']);
    }
}
