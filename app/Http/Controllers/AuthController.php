<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios', 
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        $user = Usuario::create([ 
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    

    /**
     * Handle user login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    
        // Intenta autenticar al usuario con las credenciales proporcionadas
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Detalles de inicio de sesión inválidos'
            ], 401);
        }
    
        // Recupera el usuario basado en el email
        $user = Usuario::where('email', $request->email)->firstOrFail();
    
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
