<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Lista de Materiales - FontTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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
            margin-right: 10px; /* Espacio entre botones */
        }

        .btn-warning {
            background-color: #E5A34D;
            border: none;
            margin-right: 10px; /* Espacio entre botones */
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
            border-bottom: 4px solid #E38B5B;
            /* Color cálido y sólido */
            border-radius: 8px;
            /* Bordes suaves */
            overflow: hidden;
        }

        /* Encabezado con color distintivo */
        .table thead {
            background-color: #F6B88F;
            color: #fff;
            border-top: 4px solid #E38B5B;
            /* Refuerzo del contraste */
        }

        /* Estilos para filas */
        .table th,
        .table td {
            padding: 12px;
            font-size: 14px;
            text-align: center;
            white-space: nowrap;
            border-bottom: 2px solid #E38B5B;
            /* Separación entre filas */
        }

        /* Efecto de sombra en filas al pasar el mouse */
        .table tbody tr:hover {
            background-color: rgba(227, 139, 91, 0.15);
            transition: 0.3s ease-in-out;
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
            .logo{
                border-radius: 10px;
            }
        }
    </style>
</head>

<body>
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

    <!-- Modal para subir archivos del cardex -->
    <div class="modal fade" id="modalCardex" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formCardex" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">¿Archivos del Cardex?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_lugar" class="form-label">Selecciona el Lugar:</label>
                            <select id="id_lugar" name="id_lugar" class="form-select" required>
                                <option value="">-- Selecciona un lugar --</option>
                                @foreach($lugares as $lugar)
                                    <option value="{{ $lugar->id_lugar }}">{{ $lugar->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="archivo_cardex" class="form-label">Seleccionar Archivo Excel:</label>
                            <input type="file" id="archivo_cardex" name="archivo_cardex" class="form-control"
                                accept=".xlsx,.xls" required>
                            <div class="form-text">
                                El archivo debe contener las siguientes columnas: Clave Material, Descripción, Genérico,
                                Clasificación, Existencia, Costo Promedio
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <strong>Formato requerido:</strong>
                            <ul class="mb-0">
                                <li>Clave Material</li>
                                <li>Descripción</li>
                                <li>Genérico</li>
                                <li>Clasificación</li>
                                <li>Existencia</li>
                                <li>Costo Promedio</li>
                            </ul>
                        </div>

                        <div id="progreso" class="mb-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted">Procesando archivo...</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnSubirCardex">Subir Archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h2 class="mb-3">Lista de Materiales</h2>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCardex">
                📁 Subir Cardex
            </button>
            <!-- Barra de filtrado -->
            <form class="d-flex" action="{{ route('materials') }}" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Buscar material" aria-label="Buscar"
                    value="{{ request('query') }}">
                <button class="btn btn-outline-success me-2" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro"
                id="btnNuevoMaterial">
                Registrar Material
            </button>
        </div>

        <div class="table-responsive">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Clave</th>
                        <th>Descripción</th>
                        <th>Genérico</th>
                        <th>Clasificación</th>
                        <th>Existencia</th>
                        <th>Costo ($)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materiales as $material)
                        <tr data-id="{{ $material->id_material }}">
                            <td>{{ $material->id_material }}</td>
                            <td>{{ $material->clave_material }}</td>
                            <td>{{ $material->descripcion }}</td>
                            <td>{{ $material->generico }}</td>
                            <td>{{ $material->clasificacion }}</td>
                            <td>{{ $material->existencia }}</td>
                            <td>{{ $material->costo_promedio }}</td>
                            <td class="d-flex flex-column flex-md-row">
                                <button class="btn btn-info btnVer" data-id="{{ $material->id_material }}" data-bs-toggle="modal"
                                    data-bs-target="#modalVer"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-warning btnEditar" data-id="{{ $material->id_material }}"
                                    data-bs-toggle="modal" data-bs-target="#modalRegistro"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm btnEliminar"
                                    data-id="{{ $material->id_material }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
                {{ $materiales->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal Registro/Edición -->
    <div class="modal fade" id="modalRegistro" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formRegistro">
                    @csrf
                    <input type="hidden" id="materialId">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar / Editar Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="clave_material">Clave:</label>
                        <input type="text" id="clave" name="clave_material" class="form-control" required>
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control" required>
                        <label for="generico">Genérico:</label>
                        <input type="text" id="generico" name="generico" class="form-control" required>
                        <label for="clasificacion">Clasificación:</label>
                        <input type="text" id="clasificacion" name="clasificacion" class="form-control" required>
                        <label for="existencia">Existencia:</label>
                        <input type="text" id="existencia" name="existencia" class="form-control" required>
                        <label for="costo_promedio">Costo ($):</label>
                        <input type="text" id="costo" name="costo_promedio" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarMaterial">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Material -->
    <div class="modal fade" id="modalVer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Clave:</strong> <span id="verClave"></span></p>
                    <p><strong>Descripción:</strong> <span id="verDescripcion"></span></p>
                    <p><strong>Genérico:</strong> <span id="verGenerico"></span></p>
                    <p><strong>Clasificación:</strong> <span id="verClasificacion"></span></p>
                    <p><strong>Existencia:</strong> <span id="verExistencia"></span></p>
                    <p><strong>Costo ($):</strong> <span id="verCosto"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmación de Eliminación -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este material?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Limpiar formulario al abrir el modal de registro
            $('#btnNuevoMaterial').click(function () {
                $('#materialId, #clave, #descripcion, #generico, #clasificacion, #existencia, #costo').val('');
            });

            // Enviar formulario para registrar o actualizar material
            $('#formRegistro').submit(function (event) {
                event.preventDefault();
                let id = $('#materialId').val();
                let url = id ? `/update_material/${id}` : `/register_material`;
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
                        const res = xhr.responseJSON;
                        if (res?.errors) {
                            let errores = Object.values(res.errors).flat().join('\n');
                            alert('Errores:\n' + errores);
                        } else {
                            alert('Error: ' + xhr.responseText);
                        }
                    }
                });
            });

            // Abrir modal de edición y cargar datos
            $('.btnEditar').click(function () {
                let id = $(this).data('id');
                $.get(`/edit_material/${id}`, function (response) {
                    let data = response.data;
                    $('#materialId').val(data.id_material);
                    $('#clave').val(data.clave_material);
                    $('#descripcion').val(data.descripcion);
                    $('#generico').val(data.generico);
                    $('#clasificacion').val(data.clasificacion);
                    $('#existencia').val(data.existencia);
                    $('#costo').val(data.costo_promedio);
                    $('#modalRegistro').modal('show');
                });
            });

            $('.btnVer').click(function () {
                let id = $(this).data('id');
                $.get(`/materials/${id}`, function (response) {
                    let data = response.data;
                    $('#verClave').text(data.clave_material);
                    $('#verDescripcion').text(data.descripcion);
                    $('#verGenerico').text(data.generico);
                    $('#verClasificacion').text(data.clasificacion);
                    $('#verExistencia').text(data.existencia);
                    $('#verCosto').text(data.costo_promedio);
                    $('#modalVer').modal('show');
                });
            });

            // Confirmar y eliminar material
            $('.btnEliminar').click(function () {
                let id = $(this).data('id');
                if (confirm('¿Seguro que quieres eliminar este material?')) {
                    $.ajax({
                        url: `/delete_material/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            alert(response.message);
                            $(`tr[data-id="${id}"]`).remove();
                        },
                        error: function (xhr) {
                            alert('Error al eliminar material: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Manejar el envío del formulario del cardex
            $('#formCardex').submit(function (event) {
                event.preventDefault();

                let formData = new FormData(this);
                let archivo = $('#archivo_cardex')[0].files[0];
                let lugar = $('#id_lugar').val();

                // Validaciones
                if (!archivo) {
                    alert('Por favor selecciona un archivo Excel');
                    return;
                }

                if (!lugar) {
                    alert('Por favor selecciona un lugar');
                    return;
                }

                // Validar extensión del archivo
                let extension = archivo.name.split('.').pop().toLowerCase();
                if (extension !== 'xlsx' && extension !== 'xls') {
                    alert('Por favor selecciona un archivo Excel válido (.xlsx o .xls)');
                    return;
                }

                // Mostrar progreso
                $('#progreso').show();
                $('#btnSubirCardex').prop('disabled', true);

                $.ajax({
                    url: '/materials/import-cardex',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhr: function () {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                let percentComplete = evt.loaded / evt.total * 100;
                                $('.progress-bar').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (response) {
                        alert(response.message);
                        $('#modalCardex').modal('hide');
                        location.reload();
                    },
                    error: function (xhr) {
                        const res = xhr.responseJSON;
                        if (res?.errors) {
                            let errores = Object.values(res.errors).flat().join('\n');
                            alert('Errores de validación:\n' + errores);
                        } else if (res?.message) {
                            alert('Error: ' + res.message);
                        } else {
                            alert('Error al procesar el archivo: ' + xhr.responseText);
                        }
                    },
                    complete: function () {
                        $('#progreso').hide();
                        $('#btnSubirCardex').prop('disabled', false);
                        $('.progress-bar').css('width', '0%');
                    }
                });
            });

            // Limpiar formulario al cerrar el modal
            $('#modalCardex').on('hidden.bs.modal', function () {
                $('#formCardex')[0].reset();
                $('#progreso').hide();
                $('.progress-bar').css('width', '0%');
            });
        });
    </script>
</body>

</html>