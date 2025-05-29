<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Barra de navegación con contraste suave */
        .navbar {
            background-color: #F6B88F;
            /* Color cálido y armónico */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            /* Sombra suave */
            padding: 12px 20px;
            border-bottom: 4px solid #E38B5B;
            /* Ligeramente más oscuro para contraste */
        }

        /* Logo y texto de la barra */
        .navbar .navbar-brand {
            color: #634D3B;
            /* Color tierra para armonizar */
            font-weight: bold;
            font-size: 1.6em;
            transition: color 0.3s ease-in-out;
        }

        .navbar .navbar-brand:hover {
            color: #E38B5B;
        }

        /* Estilos de los enlaces en la navbar */
        .navbar .navbar-nav .nav-link {
            color: #634D3B;
            /* Marrón claro, coherente con el estilo */
            font-size: 1em;
            padding: 10px 15px;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }

        .navbar .navbar-nav .nav-link:hover {
            background-color: rgba(227, 139, 91, 0.2);
            /* Efecto ligero al pasar el cursor */
            border-radius: 6px;
            transform: scale(1.05);
        }

        /* Botón de cerrar sesión */
        .navbar .btn-danger {
            background-color: #D9534F;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 6px;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }

        .navbar .btn-danger:hover {
            background-color: #C9302C;
            transform: scale(1.1);
        }

        /* Estilo del botón hamburguesa en móviles */
        .navbar-toggler-icon {
            filter: invert(50%);
        }

        /* Ajustes responsivos */
        @media (max-width: 768px) {
            .navbar {
                padding: 8px 15px;
            }

            .navbar .navbar-brand {
                font-size: 1.3em;
            }

            .navbar .navbar-nav .nav-link {
                font-size: 0.9em;
                padding: 8px 10px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #FCE8D5;
            /* Color cálido y natural */
            color: #634D3B;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #FFF;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #E38B5B;
            /* Color principal */
            font-size: 2em;
            font-weight: bold;
        }

        .btn {
            background-color: #E38B5B;
            /* Botón con tono cálido */
            color: #fff;
            font-size: 1.2em;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #D1784C;
            transform: scale(1.05);
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background-color: #F6B88F;
            color: #fff;
        }

        .table th,
        .table td {
            padding: 15px;
        }

        .modal-header {
            background-color: #F6B88F;
            color: #fff;
        }

        .modal-footer {
            background-color: #FCE8D5;
        }

        /* Mejoramos la interfaz de los botones dentro de la tabla */
        .btn-info {
            background-color: #88C0D0;
            border: none;
        }

        .btn-warning {
            background-color: #E5A34D;
            border: none;
        }

        .btn-danger {
            background-color: #D9534F;
            border: none;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 15px;
            list-style: none;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #E38B5B;
            /* Color Bonafont */
            color: white;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }

        .pagination li a:hover {
            background-color: #D1784C;
            transform: scale(1.1);
        }

        .pagination .active span {
            background-color: #F6B88F;
            /* Color más suave para resaltar página actual */
            color: #fff;
            border-radius: 6px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FontTrack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('materials') }}">Materiales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lugares.index') }}">Lugares</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="#">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Usuarios</h2>
        <!-- Botón para abrir el modal de registro (nuevo usuario) -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro"
            id="btnNuevoUsuario">Registrar Usuario</button>
        <table class="table mt-3" id="tablaUsuarios">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Foto</th>
                    <th>Lugar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr data-id="{{ $usuario->id_usuario }}">
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>{{ $usuario->tipo_usuario == 1 ? 'Admin' : 'Usuario' }}</td>
                        <td>
                            <!-- Se utiliza el accesorio para la URL de la foto -->
                            <img src="{{ $usuario->foto_usuario_url }}" alt="Foto" width="50">
                        </td>
                        <td>{{ optional($usuario->lugar)->nombre ?? 'Sin asignar' }}</td>
                        <td>
                            <button class="btn btn-info btnVer" data-id="{{ $usuario->id_usuario }}">Ver</button>
                            <button class="btn btn-warning btnEditar" data-id="{{ $usuario->id_usuario }}">Editar</button>
                            <button class="btn btn-danger btnEliminar"
                                data-id="{{ $usuario->id_usuario }}">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Registro/Edición -->
    <div class="modal fade" id="modalRegistro" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Nota: El formulario se envía vía AJAX, por eso no se define un action -->
                <form id="formRegistro" enctype="multipart/form-data">
                    <input type="hidden" id="usuarioId" name="id_usuario">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar / Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Deja vacío para no cambiarla">
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
                            <input type="file" id="foto_usuario" name="foto_usuario" class="form-control"
                                accept="image/png, image/jpeg">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Usuario -->
    <div class="modal fade" id="modalVer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="verNombre"></span></p>
                    <p><strong>Correo:</strong> <span id="verCorreo"></span></p>
                    <p><strong>Tipo:</strong> <span id="verTipo"></span></p>
                    <p><strong>Lugar:</strong> <span id="verLugar"></span></p>
                    <img id="verFoto" src="" alt="Foto del usuario" width="100">
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Evento para ver detalles del usuario (Modal)
            $('.btnVer').click(function () {
                let id = $(this).data('id');
                $.get(`/modal/user/${id}`, function (response) {
                    let data = response.data;
                    $('#verNombre').text(data.nombre);
                    $('#verCorreo').text(data.correo);
                    $('#verTipo').text(data.tipo_usuario == 1 ? 'Admin' : 'Usuario');
                    $('#verLugar').text(data.lugar ? data.lugar.nombre : 'Sin asignar');
                    let fotoUrl = data.foto_usuario ? `/img/${data.foto_usuario}` : `/img/usuario_default.png`;
                    $('#verFoto').attr('src', fotoUrl);
                    $('#modalVer').modal('show');
                });
            });

            // Evento para cargar datos en el modal de edición
            $('.btnEditar').click(function () {
                let id = $(this).data('id');
                $.get(`/modal/edit_user/${id}`, function (response) {
                    let data = response.data;
                    $('#usuarioId').val(data.id_usuario);
                    $('#nombre').val(data.nombre);
                    $('#correo').val(data.correo);
                    $('#tipo_usuario').val(data.tipo_usuario);
                    $('#id_lugar').val(data.id_lugar);
                    // Se limpia el campo password para que el dato actual no se muestre
                    $('#password').val('');
                    $('#modalRegistro').modal('show');
                });
            });

            // Evento para eliminar usuario
            $('.btnEliminar').click(function () {
                let id = $(this).data('id');
                if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                    $.ajax({
                        url: `/modal/delete_user/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            alert(response.message);
                            location.reload();
                        }
                    });
                }
            });

            // Envío del formulario (crear/actualizar usuario) mediante AJAX
            $('#formRegistro').submit(function (e) {
                e.preventDefault();
                let usuarioId = $('#usuarioId').val();
                let formData = new FormData(this);
                let url = usuarioId ? `/modal/update_user/${usuarioId}` : `/modal/register_user`;
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
        });
    </script>
</body>

</html>