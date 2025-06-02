<?php
namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Lugar;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    // Obtener todos los materiales
    public function index(Request $request)
    {
        $lugares = Lugar::all(); // Para el modal
        $query = $request->input('query');

        $materiales = Material::when($query, function ($q) use ($query) {
            $q->where(function ($subquery) use ($query) {
                $subquery->where('clave_material', 'like', '%' . $query . '%')
                    ->orWhere('descripcion', 'like', '%' . $query . '%')
                    ->orWhere('generico', 'like', '%' . $query . '%')
                    ->orWhere('clasificacion', 'like', '%' . $query . '%')
                    ->orWhere('existencia', 'like', '%' . $query . '%')
                    ->orWhere('costo_promedio', 'like', '%' . $query . '%');
            });
        })->paginate(10);

        return view('index_materiales', compact('materiales', 'lugares'));
    }


    // Registrar un nuevo material
    public function store(Request $request)
    {
        $request->validate([
            'clave_material' => 'required',
            'descripcion' => 'required',
            'generico' => 'nullable',
            'clasificacion' => 'nullable',
            'existencia' => 'required|integer',
            'costo_promedio' => 'required|numeric',
            'id_lugar' => 'nullable|integer|exists:tb_lugares,id_lugar',
        ]);

        $material = Material::create($request->all());
        return response()->json(['message' => 'Material agregado', 'data' => $material], 201);
    }

    // Obtener un material por ID
    public function show($id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response()->json(['error' => 'Material no encontrado'], 404);
        }
        return response()->json(['data' => $material]);
    }
    public function edit($id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response()->json(['error' => 'Material no encontrado'], 404);
        }
        return response()->json(['data' => $material]);
    }

    // Actualizar material
    public function update(Request $request, $id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response()->json(['error' => 'Material no encontrado'], 404);
        }

        $request->validate([
            'clave_material' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string|max:255',
            'generico' => 'nullable',
            'clasificacion' => 'nullable',
            'existencia' => 'required|integer',
            'costo_promedio' => 'required|numeric',
            'id_lugar' => 'nullable|integer|exists:tb_lugares,id_lugar',
        ]);

        $material->update($request->all());
        return response()->json(['message' => 'Material actualizado correctamente', 'data' => $material]);
    }

    // Eliminar material
    public function destroy($id)
    {
        Material::findOrFail($id)->delete();
        return response()->json(['message' => 'Material eliminado']);
    }

    // Importar cardex desde Excel
    public function importCardex(Request $request)
    {
        $request->validate([
            'archivo_cardex' => 'required|file|mimes:xlsx,xls|max:10240', // Máximo 10MB
            'id_lugar' => 'required|integer|exists:tb_lugares,id_lugar',
        ]);

        try {
            $archivo = $request->file('archivo_cardex');
            $spreadsheet = IOFactory::load($archivo->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $datos = $worksheet->toArray();

            // Validar encabezados
            $encabezadosRequeridos = [
                'Clave Material',
                'Descripción',
                'Genérico',
                'Clasificación',
                'Existencia',
                'Costo Promedio'
            ];

            $primeraFila = array_map('trim', $datos[0]);
            $encabezadosFaltantes = [];

            foreach ($encabezadosRequeridos as $encabezado) {
                if (!in_array($encabezado, $primeraFila)) {
                    $encabezadosFaltantes[] = $encabezado;
                }
            }

            if (!empty($encabezadosFaltantes)) {
                return response()->json([
                    'message' => 'Faltan las siguientes columnas: ' . implode(', ', $encabezadosFaltantes)
                ], 422);
            }

            // Obtener índices de las columnas
            $indices = [];
            foreach ($encabezadosRequeridos as $encabezado) {
                $indices[$encabezado] = array_search($encabezado, $primeraFila);
            }

            $materialesImportados = 0;
            $errores = [];

            DB::beginTransaction();

            // Procesar cada fila (empezar desde la fila 2, índice 1)
            for ($i = 1; $i < count($datos); $i++) {
                $fila = $datos[$i];

                // Saltar filas vacías
                if (empty(array_filter($fila))) {
                    continue;
                }

                try {
                    $datosMaterial = [
                        'clave_material' => trim($fila[$indices['Clave Material']] ?? ''),
                        'descripcion' => trim($fila[$indices['Descripción']] ?? ''),
                        'generico' => trim($fila[$indices['Genérico']] ?? ''),
                        'clasificacion' => trim($fila[$indices['Clasificación']] ?? ''),
                        'existencia' => is_numeric($fila[$indices['Existencia']] ?? 0) ? (int) $fila[$indices['Existencia']] : 0,
                        'costo_promedio' => is_numeric($fila[$indices['Costo Promedio']] ?? 0) ? (float) $fila[$indices['Costo Promedio']] : 0,
                        'id_lugar' => $request->id_lugar,
                    ];

                    // Validar datos básicos
                    if (empty($datosMaterial['clave_material']) || empty($datosMaterial['descripcion'])) {
                        $errores[] = "Fila " . ($i + 1) . ": Clave Material y Descripción son obligatorios";
                        continue;
                    }

                    // Crear o actualizar material
                    Material::updateOrCreate(
                        [
                            'clave_material' => $datosMaterial['clave_material'],
                            'id_lugar' => $datosMaterial['id_lugar']
                        ],
                        $datosMaterial
                    );

                    $materialesImportados++;

                } catch (\Exception $e) {
                    $errores[] = "Fila " . ($i + 1) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            $mensaje = "Se importaron {$materialesImportados} materiales correctamente";
            if (!empty($errores)) {
                $mensaje .= ". Errores encontrados: " . implode('; ', array_slice($errores, 0, 5));
                if (count($errores) > 5) {
                    $mensaje .= " y " . (count($errores) - 5) . " errores más.";
                }
            }

            return response()->json(['message' => $mensaje]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    // Descargar plantilla de ejemplo (opcional)
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $encabezados = ['Clave Material', 'Descripción', 'Genérico', 'Clasificación', 'Existencia', 'Costo Promedio'];
        $columna = 'A';
        foreach ($encabezados as $encabezado) {
            $sheet->setCellValue($columna . '1', $encabezado);
            $columna++;
        }

        // Ejemplo de datos
        $sheet->setCellValue('A2', 'MAT001');
        $sheet->setCellValue('B2', 'Material de ejemplo');
        $sheet->setCellValue('C2', 'Genérico ejemplo');
        $sheet->setCellValue('D2', 'Clasificación ejemplo');
        $sheet->setCellValue('E2', '100');
        $sheet->setCellValue('F2', '25.50');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'plantilla_cardex.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}