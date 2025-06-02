<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Fallos CEDIS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Reporte de Fallos CEDIS</h2>
        <form action="{{ route('reporte.enviar') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <input name="eco" placeholder="No. ECO" class="border p-2" required>
                <input name="placas" placeholder="Placas" class="border p-2" required>
                <input name="marca" placeholder="Marca" class="border p-2">
                <input name="ano" placeholder="Año" class="border p-2">
                <input name="km" placeholder="KM" class="border p-2">
                <input name="fecha" type="date" class="border p-2">
                <input name="conductor" placeholder="Nombre del Conductor" class="col-span-2 border p-2">
                <textarea name="fallo" placeholder="Descripción del Servicio / Fallo"
                    class="col-span-2 border p-2 h-32"></textarea>
                <textarea name="trabajo" placeholder="Observaciones Técnicas del Trabajo Realizado"
                    class="col-span-2 border p-2 h-32"></textarea>
                <input name="quien_reporta" placeholder="Nombre y Firma de Quien Reporta" class="border p-2">
                <input name="quien_revisa" placeholder="Nombre y Firma de Quien Revisó" class="border p-2">
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Enviar Reporte</button>
        </form>
    </div>
</body>

</html>