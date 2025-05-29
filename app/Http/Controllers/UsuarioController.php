<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Models\Lugar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuarios::with('lugar')->get();
        $lugares = Lugar::all();

        return view('index', compact('usuarios', 'lugares'));
    }

    // Función para registrar (usada tanto en peticiones normales como de modal)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'correo'       => 'required|email|unique:tb_users,correo|max:255',
            'password'     => 'required|min:6',
            'tipo_usuario' => 'required|integer',
            'foto_usuario' => 'nullable|image|mimes:jpeg,png|max:2048',
            'id_lugar'     => 'required|integer|exists:tb_lugares,id_lugar',
        ]);

        if ($request->hasFile('foto_usuario')) {
            $archivo = $request->file('foto_usuario');
            $nombreFoto = time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('img'), $nombreFoto);
            $validated['foto_usuario'] = $nombreFoto;
        } else {
            $validated['foto_usuario'] = null;
        }

        $usuario = Usuarios::create($validated);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'data'    => $usuario
        ], 201);
    }

    // Función para mostrar un usuario (incluyendo detalles y relación con Lugar) 
    public function show($id_usuario)
    {
        $usuario = Usuarios::with('lugar')->find($id_usuario);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json(['data' => $usuario]);
    }

    // Función para cargar datos del usuario para edición
    public function edit($id_usuario)
    {
        $usuario = Usuarios::with('lugar')->find($id_usuario);
        $lugares = Lugar::all();
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json(['data' => $usuario, 'lugares' => $lugares]);
    }

    // Función para actualizar la información del usuario
    public function update(Request $request, $id_usuario)
    {
        $usuario = Usuarios::find($id_usuario);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre'       => 'sometimes|required|string|max:255',
            'correo'       => 'sometimes|required|email|unique:tb_users,correo,' . $id_usuario . ',id_usuario|max:255',
            'password'     => 'nullable|min:6',
            'tipo_usuario' => 'sometimes|required|integer',
            'foto_usuario' => 'nullable|image|mimes:jpeg,png|max:2048',
            'id_lugar'     => 'sometimes|required|integer|exists:tb_lugares,id_lugar',
        ]);

        if ($request->hasFile('foto_usuario')) {
            // Eliminar la imagen anterior si existe
            if ($usuario->foto_usuario && file_exists(public_path('img/' . $usuario->foto_usuario))) {
                unlink(public_path('img/' . $usuario->foto_usuario));
            }
            $archivo = $request->file('foto_usuario');
            $nombreFoto = time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('img'), $nombreFoto);
            $validated['foto_usuario'] = $nombreFoto;
        }

        if (isset($validated['password']) && empty($validated['password'])) {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'data'    => $usuario
        ]);
    }

    // Función para eliminar un usuario y su imagen (si existe)
    public function destroy($id_usuario)
    {
        $usuario = Usuarios::find($id_usuario);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if ($usuario->foto_usuario && file_exists(public_path('img/' . $usuario->foto_usuario))) {
            unlink(public_path('img/' . $usuario->foto_usuario));
        }

        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('correo', 'password');

        // Verifica si el correo pertenece al dominio correcto
        if (!str_ends_with($credentials['correo'], '@bonafont.com')) {
            return back()->withErrors([
                'correo' => 'El correo debe ser de la empresa @bonafont.com.',
            ]);
        }

        // Busca el usuario por el correo
        $usuario = usuarios::where('correo', $credentials['correo'])->first();

        if (!$usuario) {
            return back()->withErrors([
                'correo' => 'El correo electrónico no está registrado.',
            ]);
        }

        // Verifica la contraseña
        if ($usuario->password !== $credentials['password']) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ]);
        }

        // Si las credenciales son correctas, realiza la autenticación manualmente
        Auth::login($usuario);

        return redirect()->intended('users');
    }

    //----función: logout---//
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /*
     * Funciones alias para los modales.
     * Estas funciones facilitan la diferenciación de la llamada desde modales vía AJAX,
     * aunque reutilizan la misma lógica implementada en los métodos anteriores.
     */

    public function modalShowUser($id_usuario)
    {
        return $this->show($id_usuario);
    }

    public function modalEditUser($id_usuario)
    {
        return $this->edit($id_usuario);
    }

    public function modalStoreUser(Request $request)
    {
        return $this->store($request);
    }

    public function modalUpdateUser(Request $request, $id_usuario)
    {
        return $this->update($request, $id_usuario);
    }

    public function modalDeleteUser($id_usuario)
    {
        return $this->destroy($id_usuario);
    }
}
