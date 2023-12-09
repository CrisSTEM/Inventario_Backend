<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255', 
            'password' => 'required|string|min:6',
        ]);
    
        // Recupera el usuario basado en el nombre
        $user = Usuario::where('nombre', $request->nombre)->first();

        // Verifica si el usuario existe y si la contraseña coincide
        if (!$user || $request->password !== $user->password) {
            return response()->json([
                'message' => 'Detalles de inicio de sesión inválidos'
            ], 401);
        }

        // Crea un nuevo token de acceso para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    /**
     * Handle getting the authenticated user.
     */
    public function user(Request $request)
    {
        return $request->user();
    }

    /**
     * Handle user logout (revoke the token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
