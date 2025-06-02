<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>FontTrack - Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F9E5D5;
            /* Un tono cálido pero suave */
            color: #634D3B;
            /* Texto con un tono elegante y legible */
            text-align: center;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #F4A978;
            /* Color ligeramente más vivo */
            padding: 20px;
            border-bottom: 3px solid #E38B5B;
        }

        h1 {
            font-size: 2.3em;
            font-weight: bold;
        }

        .welcome {
            padding: 45px;
        }

        .btn {
            display: inline-block;
            background-color: #E38B5B;
            /* Color cálido y elegante */
            color: #fff;
            font-size: 1.2em;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }

        .btn:hover {
            background-color: #D1784C;
            transform: scale(1.05);
        }

        footer {
            background-color: #F4A978;
            padding: 15px;
            position: absolute;
            width: 100%;
            bottom: 0;
            font-size: 0.95em;
        }
    </style>
</head>

<body>
    <header>
        <h1>FontTrack</h1>
        <p>Gestión de inventario inspirada en la frescura de Bonafont</p>
    </header>

    <main>
        <section class="welcome">
            <h2>Optimiza tu inventario con facilidad</h2>
            <p>FontTrack te ayuda a administrar tu stock de manera inteligente, eficiente y sencilla.</p>
            <a href="{{ route('login') }}" class="btn">
                <div>Ingresa</div>
            </a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FontTrack | Todos los derechos reservados</p>
    </footer>
</body>

</html>