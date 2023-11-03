<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRol;

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
                'enlace' => 'http://dotech.dyndns.biz:16666/help_ppj_api/public/generar_password/' . $api_token
            ];
            $respuesta = \Mail::send('emails.solicitud_password', ['data' => $data], function ($mail) use ($user) {
                $mail->from('my_heldesk_pj@papajohnsmexico.com', env('APP_NAME'));
                $mail->to([$user->email]);
                //$mail->attachData($pdf->output(), 'Cotizacion_' . $sale->id . '.pdf');
            });
            \Log($respuesta);
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
            \Mail::send('emails.generar_password', ['data' => $data], function ($mail) use ($user) {
                $mail->from('my_heldesk_pj@papajohnsmexico.com', env('APP_NAME'));
                $mail->to([$user->email]);
                //$mail->attachData($pdf->output(), 'Cotizacion_' . $sale->id . '.pdf');
            });
            return "<script>alert('Por favor revise su bandeja de entrada');window.location = 'https://google.com';</script>";
        } else {
            return "<script>alert('La solicitud es incorrecta');window.location = 'https://google.com';</script>";
        }
    }

    public function apiActualizarPassword(Request $request)
    {
        $user = User::where('email', auth()->user()->email)->first();
        if ($user) {
            if (\Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->new_password);
                $user->save();
                return response()->json([
                    "estatus" => 1,
                    "mensaje" => "Su password ha sido actualizado."
                ]);
            } else {
                return response()->json([
                    "estatus" => 0,
                    "mensaje" => "El password actual es incorrecto"
                ]);
            }
        } else {
            return response()->json([
                "estatus" => 0,
                "mensaje" => "error al validar el usuario."
            ]);
        }
        //return $request;
    }

    public function index()
    {
        $usuarios = User::paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = UserRol::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_rol_id' => 'required',
            'status' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ], [
            'user_rol_id.required' => 'Campo obligatorio',
            'status.required' => 'Campo obligatorio',
            'name.required' => 'Campo obligatorio',
            'email.required' => 'Campo obligatorio',
            'password.required' => 'Campo obligatorio',
            'password.confirmed' => 'La confirmación no coincide',
            'password.min' => 'El password debe ser de 6 caracteres como mínimo',
            'password_confirmation.required' => 'Campo obligatorio',
        ]);

        $usuario = User::create([
            'user_rol_id' => $request->user_rol_id,
            'status' => $request->status,
            'name' => $request->name,
            'username' => $request->name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'centro_costo' => $request->centro_costo,
        ]);

        if ($usuario) {
            return redirect()->route('index_usuarios')->with('message', 'El usuario ' . $usuario->email . ' se creó con éxito.');
        }
    }

    public function edit($id)
    {
        $roles = UserRol::all();
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('roles', 'usuario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_rol_id' => 'required',
            'status' => 'required',
            'name' => 'required',
        ], [
            'user_rol_id.required' => 'Campo obligatorio',
            'status.required' => 'Campo obligatorio',
            'name.required' => 'Campo obligatorio',
        ]);
        $usuario = User::findOrFail($id);
        if ($usuario->update($request->all())) {
            return redirect()->route('index_usuarios')->with('message', 'El usuario ' . $usuario->email . ' se actualizó con éxito.');
        }
    }

    public function editPassword($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit_password', compact('usuario'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'Campo obligatorio',
            'password.confirmed' => 'La confirmación no coincide',
            'password.min' => 'El password debe ser de 6 caracteres como mínimo',
            'password_confirmation.required' => 'Campo obligatorio',
        ]);
        $usuario = User::findOrFail($id);
        $usuario->password = bcrypt($request->password);
        if ($usuario->save())
            return redirect()->route('index_usuarios')->with('message', 'El password del usuario ' . $usuario->email . ' se actualizó con éxito.');
    }

    public function delete(Request $request)
    {
        $usuario = User::findOrFail($request->usuario_id);
        if ($usuario->delete()) {
            return response()->json([
                'status' => 1,
                'message' => "Usuario eliminado"
            ]);
        }
    }
}
