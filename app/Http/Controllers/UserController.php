<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['apiLogin']);
    }

    public function apiLogin(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if ($user) {

            if ($user->status == 'Activo') {
                if (\Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        "estatus" => 1,
                        "mensaje" => "Inicio de sesión correcto.",
                        "auth_token" => $token,
                        "usuario" => $user,
                    ]);
                } else {
                    return response()->json([
                        "estatus" => 0,
                        "mensaje" => "Su contraseña de acceso es incorrecta.",
                    ]);
                }
            } else {
                $user->tokens()->delete();
                return response()->json([
                    "estatus" => 0,
                    "mensaje" => "El usuario se encuentra inactivo por favor verifiquélo con su supervisor.",
                ]);
            }
        } else {
            return response()->json([
                "estatus" => 0,
                "mensaje" => "El usuario no se encuentra registrado en el sistema.",
            ]);
        }
    }
    public function apiLogout()
    {
        // eliminar todas las sesiones
        //auth()->user()->tokens()->delete();
        //eliminar sesión actual
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            "estatus" => 1,
            "mensaje" => "La sesión se cerró exitosamente.",
        ]);
    }
    public function apiDatosUsuario()
    {
        return response()->json([
            "estatus" => 1,
            "mensaje" => "Información del usuario.",
            "usuario" => auth()->user(),
        ]);
    }
}
