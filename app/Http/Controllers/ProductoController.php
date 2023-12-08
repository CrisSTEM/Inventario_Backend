<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // Asegúrate de usar el namespace correcto de tu modelo

class ProductoController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {
        return Producto::all();
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'existencia' => 'required|integer',
            'precio' => 'required|numeric'
        ]);

        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    // Mostrar un producto específico
    public function show($id)
    {
        return Producto::find($id);
    }

    // Actualizar un producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'existencia' => 'required|integer',
            'precio' => 'required|numeric'
        ]);

        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $producto->update($request->all());
        return response()->json($producto, 200);
    }

    // Eliminar un producto
    public function destroy($id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $producto->delete();
        return response()->json(['mensaje' => 'Producto eliminado'], 200);
    }
}
