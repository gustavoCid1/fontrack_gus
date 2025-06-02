<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Lugares</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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


        link[rel="icon"] {
            width: 32px;
            height: 32px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #FCE8D5;
            color: #634D3B;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #FFF;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #E38B5B;
            font-size: 1.8em;
            font-weight: bold;
        }

        /* Botón principal */
        .btn {
            background-color: #E38B5B;
            color: #fff;
            font-size: 0.85em;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-sm {
            font-size: 0.75em;
            padding: 5px 10px;
        }

        .btn:hover {
            background-color: #D1784C;
            transform: scale(1.05);
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

        /* Tabla responsiva */
        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
        }

        /* Estilos para la tabla */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: #F6B88F;
            color: #fff;
        }

        .table th,
        .table td {
            padding: 10px;
            font-size: 14px;
            text-align: center;
            white-space: nowrap;
        }

        /* Paginación */
        .pagination {
            display: flex;
            justify-content: center;
            padding: 10px;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            text-decoration: none;
            padding: 8px 12px;
            background-color: #E38B5B;
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
            color: #fff;
            border-radius: 6px;
            font-weight: bold;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            h2 {
                font-size: 1.5em;
            }

            .table th,
            .table td {
                font-size: 12px;
                padding: 8px;
            }

            .btn {
                font-size: 0.8em;
                padding: 6px 12px;
            }

            .pagination li a,
            .pagination li span {
                padding: 6px 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <img src="{{ 'img/FontTrack.png' }}" alt="logo" height="70px" width="100px" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('users') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('materials') }}">Materiales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lugares.index') }}">Lugares</a>
                    </li>
                    <!-- Botón de cerrar sesión -->
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Lugares</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">Nuevo Lugar</button>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive mt-3">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lugares as $lugar)
                        <tr data-id="{{ $lugar->id_lugar }}">
                            <td>{{ $lugar->nombre }}</td>
                            <td>{{ $lugar->estado ?? 'Sin especificar' }}</td>
                            <td>
                                <button class="btn btn-info btnVer" data-id="{{ $lugar->id_lugar }}">Ver</button>
                                <button class="btn btn-warning btnEditar" data-id="{{ $lugar->id_lugar }}">Editar</button>
                                <button class="btn btn-danger btnEliminar"
                                    data-id="{{ $lugar->id_lugar }}">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Registro/Edición -->
    <div class="modal fade" id="modalRegistro" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formLugar">
                    @csrf
                    <input type="hidden" id="lugarId">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar / Editar Lugar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>

                        <label for="estado" class="mt-2">Estado:</label>
                        <input type="text" id="estado" name="estado" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Lugar -->
    <div class="modal fade" id="modalVer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Lugar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="verNombre"></span></p>
                    <p><strong>Estado:</strong> <span id="verEstado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.btnEditar').click(function () {
                let id = $(this).data('id');
                $.get(`/lugares/${id}/edit`, function (response) {
                    $('#lugarId').val(response.data.id_lugar);
                    $('#nombre').val(response.data.nombre);
                    $('#estado').val(response.data.estado);
                    $('#modalRegistro').modal('show');
                });
            });

            $('.btnVer').click(function () {
                let id = $(this).data('id');
                $.get(`/lugares/${id}`, function (response) {
                    $('#verNombre').text(response.data.nombre);
                    $('#verEstado').text(response.data.estado || 'Sin especificar');
                    $('#modalVer').modal('show');
                });
            });

            $('.btnEliminar').click(function () {
                let id = $(this).data('id');
                if (confirm('¿Seguro que quieres eliminar este lugar?')) {
                    $.ajax({
                        url: `/lugares/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            alert(response.message);
                            location.reload();
                        },
                        error: function (xhr) {
                            alert('Error al eliminar lugar: ' + xhr.responseText);
                        }
                    });
                }
            });

            $('#formLugar').submit(function (event) {
                event.preventDefault();
                let id = $('#lugarId').val();
                let url = id ? `/lugares/${id}` : `/lugares`;
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error al guardar: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>