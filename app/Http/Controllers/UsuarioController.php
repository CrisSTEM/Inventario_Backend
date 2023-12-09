<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Obtener todos los usuarios
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:50',
            'password' => 'required|min:6',
        ]);

        $usuario = new Usuario();
        $usuario->nombre = $validatedData['nombre'];
        $usuario->password = Hash::make($validatedData['password']);
        $usuario->save();

        return response()->json(['mensaje' => 'Usuario creado con éxito', 'usuario' => $usuario]);
    }

    // Obtener un usuario específico
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nombre' => 'max:50',
            'password' => 'min:6',
        ]);

        if (isset($validatedData['nombre'])) {
            $usuario->nombre = $validatedData['nombre'];
        }
        if (isset($validatedData['password'])) {
            $usuario->password = Hash::make($validatedData['password']);
        }

        $usuario->save();

        return response()->json(['mensaje' => 'Usuario actualizado con éxito', 'usuario' => $usuario]);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['mensaje' => 'Usuario eliminado con éxito']);
    }
}
