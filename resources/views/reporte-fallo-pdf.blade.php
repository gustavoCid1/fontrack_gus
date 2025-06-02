<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Falla</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Reporte de Falla - CEDIS</h1>
    <p><strong>No. ECO:</strong> {{ $data['eco'] ?? 'N/A' }}</p>
    <p><strong>Placas:</strong> {{ $data['placas'] ?? 'N/A' }}</p>
    <p><strong>Marca:</strong> {{ $data['marca'] ?? 'N/A' }}</p>
    <p><strong>Año:</strong> {{ $data['anio'] ?? 'N/A' }}</p>
    <p><strong>KM:</strong> {{ $data['km'] ?? 'N/A' }}</p>
    <p><strong>Nombre del conductor:</strong> {{ $data['conductor'] ?? 'N/A' }}</p>
    <p><strong>Fecha:</strong> {{ $data['fecha'] ?? now()->format('Y-m-d') }}</p>

    <h3>Descripción del Servicio / Fallo:</h3>
    <p>{{ $data['descripcion'] ?? 'N/A' }}</p>

    <h3>Observaciones Técnicas del Trabajo Realizado:</h3>
    <p>{{ $data['observaciones'] ?? 'N/A' }}</p>

    <br>
    <p><strong>Firma quien reporta:</strong> ________________________</p>
    <p><strong>Firma quien revisa:</strong> ________________________</p>
</body>

</html>