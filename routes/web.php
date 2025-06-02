<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\LugarController;
use App\Http\Controllers\ReporteController;
use App\Models\Lugar;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas web para tu aplicación. Estas rutas
| son cargadas por el RouteServiceProvider dentro del grupo que contiene
| el middleware "web".
*/

/* ====================
   PÁGINA DE INICIO
==================== */
Route::get('/', function () {
    return view('welcome');
});


/* ============================
   AUTENTICACIÓN Y SESIÓN
============================ */
Route::get('/login', function () {
    $lugares = Lugar::all(); // Mostrar lugares en login
    return view('login', compact('lugares'));
})->name('login.view');

Route::post('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');


/* ============================
   DASHBOARD (solo admins)
============================ */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


/* ====================
   CRUD: USUARIOS
==================== */
Route::get('/users', [UsuarioController::class, 'index'])->name('users');             // Listar usuarios
Route::get('/users/{id}', [UsuarioController::class, 'show'])->name('user_detail');   // Ver detalle de usuario
Route::post('/register_user', [UsuarioController::class, 'store'])->name('register_user');  // Crear
Route::get('/edit_user/{id}', [UsuarioController::class, 'edit'])->name('edit_user');       // Editar (vista)
Route::put('/update_user/{id}', [UsuarioController::class, 'update'])->name('update_user'); // Actualizar
Route::delete('/delete_user/{id}', [UsuarioController::class, 'destroy'])->name('delete_user'); // Eliminar


/* ===========================================
   CRUD vía MODAL (AJAX): USUARIOS
=========================================== */
Route::prefix('modal')->group(function () {
    Route::get('/user/{id}', [UsuarioController::class, 'show'])->name('modal_show_user');
    Route::get('/edit_user/{id}', [UsuarioController::class, 'edit'])->name('modal_edit_user');
    Route::post('/register_user', [UsuarioController::class, 'store'])->name('modal_register_user');
    Route::put('/update_user/{id}', [UsuarioController::class, 'update'])->name('modal_update_user');
    Route::delete('/delete_user/{id}', [UsuarioController::class, 'destroy'])->name('modal_delete_user');
});


/* ====================
   CRUD: MATERIALES
==================== */
Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
Route::get('/materials/{id}', [MaterialController::class, 'show'])->name('material_detail');
Route::post('/register_material', [MaterialController::class, 'store'])->name('register_material');
Route::get('/edit_material/{id}', [MaterialController::class, 'edit'])->name('edit_material');
Route::put('/update_material/{id}', [MaterialController::class, 'update'])->name('update_material');
Route::delete('/delete_material/{id}', [MaterialController::class, 'destroy'])->name('delete_material');

// Importar Cardex y descargar plantilla
Route::post('/materials/import-cardex', [MaterialController::class, 'importCardex'])->name('materials.import-cardex');
Route::get('/materials/download-template', [MaterialController::class, 'downloadTemplate'])->name('materials.download-template');


/* ===========================================
   CRUD vía MODAL (AJAX): MATERIALES
=========================================== */
Route::prefix('modal')->group(function () {
    Route::get('/material/{id}', [MaterialController::class, 'show'])->name('modal_show_material');
    Route::get('/edit_material/{id}', [MaterialController::class, 'edit'])->name('modal_edit_material');
    Route::post('/register_material', [MaterialController::class, 'store'])->name('modal_register_material');
    Route::put('/update_material/{id}', [MaterialController::class, 'update'])->name('modal_update_material');
    Route::delete('/delete_material/{id}', [MaterialController::class, 'destroy'])->name('modal_delete_material');
});


/* ====================
   CRUD: LUGARES
==================== */
Route::prefix('lugares')->name('lugares.')->group(function () {
    Route::get('/', [LugarController::class, 'index'])->name('index');         // Listar lugares
    Route::get('/create', [LugarController::class, 'create'])->name('create'); // Formulario crear
    Route::post('/', [LugarController::class, 'store'])->name('store');        // Guardar
    Route::get('/{id_lugar}', [LugarController::class, 'show'])->name('show'); // Ver detalle
    Route::get('/{id_lugar}/edit', [LugarController::class, 'edit'])->name('edit'); // Editar
    Route::put('/{id_lugar}', [LugarController::class, 'update'])->name('update');  // Actualizar
    Route::delete('/{id_lugar}', [LugarController::class, 'destroy'])->name('destroy'); // Eliminar
});


/* =========================
   REPORTE DE FALLOS (CEDIS)
========================= */
Route::get('/reporte', function () {
    return view('reporte_fallo');
})->name('reporte.form');

Route::post('/reporte', [ReporteController::class, 'enviar'])->name('reporte.enviar');

