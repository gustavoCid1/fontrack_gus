<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lugar;

class LugarController extends Controller
{
    public function index()
{
    $lugares = Lugar::all(); // Obtener todos los lugares de la base de datos
    return view('lugares', compact('lugares')); // Pasar la variable a la vista
}

public function create()
{
    return view('lugares'); // Asegúrate de tener esta vista en `resources/views/lugares/create.blade.php`
}


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'nullable|string|max:255'
        ]);

        $lugar = Lugar::create($request->all());

        return response()->json(['message' => 'Lugar creado correctamente', 'data' => $lugar], 201);
    }

    public function show($id_lugar)
    {
        $lugar = Lugar::findOrFail($id_lugar);
        return response()->json(['data' => $lugar]);
    }

    public function edit($id_lugar)
    {
        $lugar = Lugar::findOrFail($id_lugar);
        return response()->json(['data' => $lugar]);
    }

    public function update(Request $request, $id_lugar)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'nullable|string|max:255'
        ]);

        $lugar = Lugar::findOrFail($id_lugar);
        $lugar->update($request->all());

        return response()->json(['message' => 'Lugar actualizado correctamente', 'data' => $lugar]);
    }

    public function destroy($id_lugar)
    {
        $lugar = Lugar::findOrFail($id_lugar);
        $lugar->delete();

        return response()->json(['message' => 'Lugar eliminado correctamente']);
    }
}
