<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ReporteController extends Controller
{
    public function enviar(Request $request)
    {
        $data = $request->all();
        $data = $request->validate([
        'correo' => 'required|email',
        'asunto' => 'required|string',
        'descripcion' => 'required|string',
        'lugar' => 'nullable|string',
    ]);

        // Generar el PDF
        $pdf = Pdf::loadView('reporte-fallo-pdf', compact('data'));

        // Guardar PDF temporalmente
        $pdfPath = storage_path('app/public/reporte_fallo.pdf');
        $pdf->save($pdfPath);

        // Enviar correo con el PDF adjunto
        Mail::send('emails.reporte_enviado', ['data' => $data], function($message) use ($data, $pdfPath) {
            $message->to($data['correo'])
                ->subject('Reporte de Falla Recibido')
                ->attach($pdfPath);
        });

        // Eliminar PDF temporal
        Storage::delete('public/reporte_fallo.pdf');

        return back()->with('success', 'Reporte enviado correctamente por correo.');
    }
}
