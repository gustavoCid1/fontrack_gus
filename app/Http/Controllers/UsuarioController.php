<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Models\Lugar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuarios::with('lugar')->get();
        $lugares = Lugar::all();

        return view('index', compact('usuarios', 'lugares'));
    }

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

        $validated['password'] = Hash::make($validated['password']);

        $usuario = Usuarios::create($validated);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'data'    => $usuario
        ], 201);
    }

    public function show($id_usuario)
    {
        $usuario = Usuarios::with('lugar')->find($id_usuario);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json(['data' => $usuario]);
    }

    public function edit($id_usuario)
    {
        $usuario = Usuarios::with('lugar')->find($id_usuario);
        $lugares = Lugar::all();
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json(['data' => $usuario, 'lugares' => $lugares]);
    }

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
            if ($usuario->foto_usuario && file_exists(public_path('img/' . $usuario->foto_usuario))) {
                unlink(public_path('img/' . $usuario->foto_usuario));
            }
            $archivo = $request->file('foto_usuario');
            $nombreFoto = time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('img'), $nombreFoto);
            $validated['foto_usuario'] = $nombreFoto;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'data'    => $usuario
        ]);
    }

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

        if (!str_ends_with($credentials['correo'], '@bonafont.com')) {
            return back()->withErrors([
                'correo' => 'Solo se admiten correos con el dominio @bonafont.com',
            ]);
        }

        $usuario = Usuarios::where('correo', $credentials['correo'])->first();

        if (!$usuario) {
            return back()->withErrors([
                'correo' => 'El correo electrónico no está registrado.',
            ]);
        }

        if (!Hash::check($credentials['password'], $usuario->password)) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ]);
        }

        Auth::login($usuario);

        return redirect()->action([UsuarioController::class, 'index']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

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
