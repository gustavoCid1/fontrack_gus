<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FontTrack</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap CSS para el modal --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== Estilos Generales de la Página ===== */
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

        /* ===== Card del Login ===== */
        .card {
            background-color: #FFF;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        .title {
            font-size: 1.7em;
            margin-bottom: 20px;
            color: #E38B5B;
            font-weight: bold;
            text-align: center;
        }

        .field {
            margin-bottom: 18px;
        }

        .input-field {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #E0C4AA;
            border-radius: 8px;
            font-size: 1em;
            background-color: #fffaf6;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border-color: #E38B5B;
            outline: none;
        }

        .alert {
            display: block;
            margin-top: 6px;
            font-size: 0.88em;
            color: #D9534F;
        }

        /* ===== Botones ===== */
        .btn,
        .btn-secondary {
            display: inline-block;
            background-color: #E38B5B;
            color: white;
            font-weight: bold;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .btn:hover,
        .btn-secondary:hover {
            background-color: #D1784C;
            transform: scale(1.02);
        }

        .btn-secondary {
            background-color: #c49a6c;
            margin-top: 10px;
        }

        .btn-link {
            display: block;
            margin-top: 12px;
            text-align: center;
            color: #634D3B;
            font-size: 0.95em;
            text-decoration: none;
        }

        .btn-link:hover {
            color: #E38B5B;
        }

        /* ===== Estilos para Inputs y Selects del Modal ===== */
        /* Sobrescribimos ligeramente .form-control de Bootstrap para que combine con nuestro tema */
        .modal .form-control {
            background-color: #fffaf6;
            border: 1px solid #E0C4AA;
            border-radius: 6px;
            transition: border-color 0.3s ease;
        }

        .modal .form-control:focus {
            border-color: #E38B5B;
            box-shadow: none;
        }

        /* Encabezado del Modal */
        .modal-header {
            background-color: #F6B88F;
            border-bottom: 2px solid #E38B5B;
        }

        .modal-title {
            color: #634D3B;
            font-weight: bold;
            font-size: 1.2em;
        }

        /* Botones del Modal */
        .modal .btn-primary {
            background-color: #E38B5B;
            border: none;
            border-radius: 6px;
            padding: 8px 14px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal .btn-primary:hover {
            background-color: #D1784C;
            transform: scale(1.05);
        }

        .modal .btn-secondary {
            background-color: #c49a6c;
            border: none;
            border-radius: 6px;
            padding: 8px 14px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal .btn-secondary:hover {
            background-color: #A9866A;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    {{-- Card de Login --}}
    <div class="card">
        <h4 class="title">Inicia Sesión</h4>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <input
                    autocomplete="off"
                    id="logemail"
                    placeholder="Correo"
                    class="input-field"
                    name="correo"
                    type="email"
                    required
                    value="{{ old('correo') }}"
                >
                @if ($errors->has('correo'))
                    <span class="alert">{{ $errors->first('correo') }}</span>
                @endif
            </div>

            <div class="field">
                <input
                    autocomplete="off"
                    id="logpass"
                    placeholder="Contraseña"
                    class="input-field"
                    name="password"
                    type="password"
                    required
                >
                @if ($errors->has('password'))
                    <span class="alert">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button class="btn" type="submit">Entrar</button>
            <a href="{{ url('/') }}" class="btn-secondary">Regresar</a>
            {{-- Botón que abre el modal --}}
            <a
                href="#"
                class="btn-link"
                data-bs-toggle="modal"
                data-bs-target="#modalRegistro"
                id="btnNuevoUsuario"
            >Registrar</a>
            <a href="#" class="btn-link">¿Olvidaste tu contraseña?</a>
        </form>
    </div>

    {{-- Modal Registro/Edición --}}
    <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formRegistro" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="usuarioId" name="id_usuario">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegistroLabel">Registrar / Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="correoRegistro" class="form-label">Correo:</label>
                            <input type="email" id="correoRegistro" name="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="passwordRegistro" class="form-label">Contraseña:</label>
                            <input type="password" id="passwordRegistro" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuario:</label>
                            <select id="tipo_usuario" name="tipo_usuario" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">Usuario</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="foto_usuario" class="form-label">Seleccionar Foto:</label>
                            <input
                                type="file"
                                id="foto_usuario"
                                name="foto_usuario"
                                class="form-control"
                                accept="image/png, image/jpeg"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="id_lugar" class="form-label">Seleccionar Lugar:</label>
                            <select id="id_lugar" name="id_lugar" class="form-control">
                                @foreach($lugares as $lugar)
                                    <option value="{{ $lugar->id_lugar }}">{{ $lugar->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS (para el modal) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JQuery para el envío AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Envío del formulario (crear/actualizar usuario) mediante AJAX
        $('#formRegistro').submit(function (e) {
            e.preventDefault();
            let usuarioId = $('#usuarioId').val();
            let formData = new FormData(this);
            let url = usuarioId
                ? `/modal/update_user/${usuarioId}`
                : `/modal/register_user`;
            let method = usuarioId ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function (key, value) {
                        errorMsg += value + '\n';
                    });
                    alert(errorMsg);
                }
            });
        });

        // Al abrir el modal para nuevo usuario, se resetea el formulario
        $('#btnNuevoUsuario').click(function () {
            $('#formRegistro')[0].reset();
            $('#usuarioId').val('');
        });
    </script>
</body>
</html>
