<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->except(['apiLogin']);
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

    public function apiSolicitarPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $api_token = \Str::random(27);
            $user->api_token = $api_token;
            $user->save();

            $data = [
                'user' => $user,
                'enlace' => 'http://' . env('SERVER_URL') . '/help_ppj_api/public/generar_password/' . $api_token
            ];
            \Mail::send('emails.solicitud_password', ['data' => $data], function ($mail) {
                $mail->from('my_heldesk_pj@papajohnsmexico.com', env('APP_NAME'));
                $mail->to(['contacto@mail.com']);
                //$mail->attachData($pdf->output(), 'Cotizacion_' . $sale->id . '.pdf');
            });
            return response()->json([
                "estatus" => 1,
                "mensaje" => "El correo de confirmación ha sido enviado, por favor revise su bandeja de entrada.",
            ]);
        } else {
            return response()->json([
                "estatus" => 0,
                "mensaje" => "El usuario no se encuentra en nuestros registros."
            ]);
        }
    }

    public function generarPassword($token)
    {
        $user = User::where('api_token', $token)->first();
        if ($user) {
            $passwordTemporal = \Str::random(6);
            $user->password = bcrypt($passwordTemporal);
            $user->api_token = null;
            $user->save();
            $data = [
                'user' => $user,
                'temporal_pass' => $passwordTemporal
            ];
            \Mail::send('emails.generar_password', ['data' => $data], function ($mail) {
                $mail->from('my_heldesk_pj@papajohnsmexico.com', env('APP_NAME'));
                $mail->to(['contacto@mail.com']);
                //$mail->attachData($pdf->output(), 'Cotizacion_' . $sale->id . '.pdf');
            });
            return "<script>alert('Por favor revise su bandeja de entrada');window.location = 'https://google.com';</script>";
        } else {
            return "<script>alert('La solicitud es incorrecta');window.location = 'https://google.com';</script>";
        }
    }
}
