<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Login - FontTrack</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FCE8D5;
            color: #634D3B;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #FFF;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h4 {
            color: #E38B5B;
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-container {
            background: #FFF9F1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: inset 0px 0px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .field {
            margin-bottom: 15px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            border: 1px solid #E38B5B;
            border-radius: 8px;
            outline: none;
            font-size: 16px;
            text-align: center;
            background-color: #FFF9F1;
        }

        .btn {
            background-color: #E38B5B;
            color: white;
            font-size: 1.2em;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            width: 100%;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #D1784C;
            transform: scale(1.05);
        }

        .btn-link {
            display: block;
            margin-top: 10px;
            color: #E38B5B;
            font-size: 14px;
            text-decoration: none;
        }

        .alert {
            color: #D9534F;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <body>
        <div class="card"
            style="display: flex; justify-content: center; align-items: center; height: 100vh; width: 100%;">
            <div class="container">
                <h4>Inicio de sesión</h4>
                <div class="form-container">
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="field">
                            <input autocomplete="off" id="logemail" placeholder="Correo" class="input-field"
                                name="correo" type="email" required>
                        </div>
                        <div class="field">
                            <input autocomplete="off" id="logpass" placeholder="Contraseña" class="input-field"
                                name="password" type="password" required>
                        </div>
                        <button class="btn" type="submit">Entrar</button>
                        <a href="{{ url('/') }}" class="btn">Regresar</a>
                        <a href="#" class="btn-link">Olvidaste tu Contraseña?</a>
                    </form>
                </div>
            </div>
        </div>
    </body>

</body>

</html>